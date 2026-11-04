<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FlavisurReportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'report_test', 'database.connections.report_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]]);
        Schema::create('inductions', function (Blueprint $t) {
            $t->id(); $t->integer('id_company'); $t->integer('id_workshop'); $t->integer('intentos'); $t->integer('status');
        });
        Schema::create('induction_workers', function (Blueprint $t) {
            $t->id(); $t->integer('id_induction'); $t->integer('num_report')->default(0); $t->integer('status'); $t->timestamps();
        });
        Schema::create('detail_induction_workers', function (Blueprint $t) {
            $t->id();
            foreach (['induction_worker_id','report','entrenamiento','identified','risk_level','correct_measure','num_errors'] as $field) {
                $t->integer($field);
            }
            foreach (['case','time','difficulty','start_date','end_date'] as $field) { $t->string($field); }
            $t->text('json')->nullable(); $t->float('note'); $t->float('note_reference'); $t->timestamps();
        });
        DB::table('inductions')->insert(['id'=>179,'id_company'=>12,'id_workshop'=>40,'intentos'=>10,'status'=>1]);
        DB::table('induction_workers')->insert(['id'=>4060,'id_induction'=>179,'num_report'=>0,'status'=>1]);
    }

    private function body(int $attempt = 1): array
    {
        return ['cabecera_id'=>4060,'intento'=>$attempt,'entrenamiento'=>false,'json_data'=>[
            'condition'=>['shovelModel'=>'P&H 4100'],'collisions'=>['truck'=>1],
            'buckets'=>[],'trucks'=>[],'times'=>['Total'=>'00:31:00'],
        ]];
    }

    public function test_replaces_same_attempt_without_consuming_another(): void
    {
        $response = $this->postJson('/api/v1/reports/submit', $this->body())->assertOk()->assertJson(['replaced'=>false]);
        $id = $response->json('detail_induction_worker_id');
        $body = $this->body();
        $body['json_data']['nota'] = 0;
        $body['json_data']['collisions']['truck'] = 5;
        $this->postJson('/api/v1/reports/submit', $body)->assertOk()->assertJson(['replaced'=>true,'detail_induction_worker_id'=>$id]);
        $this->assertDatabaseCount('detail_induction_workers', 1);
        $this->assertDatabaseHas('detail_induction_workers', ['id'=>$id,'note'=>0]);
        $this->assertSame(5, json_decode(DB::table('detail_induction_workers')->value('json'),true)['collisions']['truck']);
        $this->assertDatabaseHas('induction_workers', ['id'=>4060,'num_report'=>1]);
        $this->postJson('/api/v1/reports/submit', $this->body())->assertOk();
        $this->assertDatabaseHas('detail_induction_workers', ['id'=>$id,'note'=>20]);
        $this->postJson('/api/v1/reports/submit', $this->body(2))->assertOk();
        $this->assertDatabaseCount('detail_induction_workers', 2);
    }

    public function test_limits_scope_and_attempts_and_separates_training(): void
    {
        $this->postJson('/api/v1/reports/submit', $this->body(11))->assertStatus(422);
        $training = $this->body(); $training['entrenamiento'] = true;
        $this->postJson('/api/v1/reports/submit', $training)->assertOk();
        $this->assertDatabaseHas('induction_workers', ['num_report'=>0]);
        $this->postJson('/api/v1/reports/submit', $this->body())->assertOk();
        $this->assertDatabaseCount('detail_induction_workers', 2);
        DB::table('inductions')->update(['id_company'=>8]);
        $this->postJson('/api/v1/reports/submit', $this->body())->assertStatus(422);
        DB::table('inductions')->update(['id_company'=>12,'id_workshop'=>41]);
        $this->postJson('/api/v1/reports/submit', $this->body())->assertStatus(422);
        $this->assertDatabaseCount('detail_induction_workers', 2);
    }

    public function test_legacy_endpoint_still_rejects_completed_details(): void
    {
        $r = $this->postJson('/api/v1/reports/submit', $this->body())->assertOk();
        $this->postJson('/api/v1/reports/submit', [
            'detail_induction_worker_id'=>$r->json('detail_induction_worker_id'), 'json_data'=>['test'=>true],
        ])->assertStatus(400);
    }
}
