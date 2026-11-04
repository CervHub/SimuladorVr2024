<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class PalaMineraReportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'report_test', 'database.connections.report_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]]);
        Schema::create('inductions', function (Blueprint $t) {
            $t->id(); $t->integer('id_company'); $t->integer('intentos'); $t->integer('status');
        });
        Schema::create('induction_workers', function (Blueprint $t) {
            $t->id(); $t->integer('id_induction'); $t->integer('num_report')->default(0);
            $t->integer('status'); $t->timestamps();
        });
        Schema::create('detail_induction_workers', function (Blueprint $t) {
            $t->id();
            foreach (['induction_worker_id', 'report', 'entrenamiento', 'identified', 'risk_level', 'correct_measure', 'num_errors'] as $field) {
                $t->integer($field);
            }
            foreach (['case', 'time', 'difficulty', 'start_date', 'end_date'] as $field) {
                $t->string($field);
            }
            $t->text('json')->nullable(); $t->float('note'); $t->float('note_reference'); $t->timestamps();
        });
        DB::table('inductions')->insert(['id' => 179, 'id_company' => 12, 'intentos' => 10, 'status' => 1]);
        DB::table('induction_workers')->insert(['id' => 4060, 'id_induction' => 179, 'num_report' => 0, 'status' => 1]);
    }

    private function body(int $attempt): array
    {
        return ['cabecera_id' => 4060, 'intento' => $attempt, 'entrenamiento' => false, 'json_data' => [
            'condition' => ['shovelModel' => 'P&H 4100'], 'collisions' => [],
            'buckets' => [], 'trucks' => [], 'times' => ['Total' => '00:31:00'],
        ]];
    }

    public function test_saves_attempts_without_overwriting_and_defaults_note(): void
    {
        $this->postJson('/api/v1/reports/submit', $this->body(1))->assertOk()->assertJson(['intento' => 1]);
        $this->assertDatabaseHas('detail_induction_workers', ['report' => 1, 'note' => 20]);
        $this->postJson('/api/v1/reports/submit', $this->body(1))->assertStatus(400);
        $next = $this->body(2);
        $next['json_data']['nota'] = 0;
        $this->postJson('/api/v1/reports/submit', $next)->assertOk();
        $this->assertDatabaseCount('detail_induction_workers', 2);
        $this->assertDatabaseHas('detail_induction_workers', ['report' => 2, 'note' => 0]);
        $this->assertDatabaseHas('induction_workers', ['id' => 4060, 'num_report' => 2]);
    }

    public function test_rejects_excess_attempts_and_keeps_training_separate(): void
    {
        $this->postJson('/api/v1/reports/submit', $this->body(11))->assertStatus(422);
        $training = $this->body(1);
        $training['entrenamiento'] = true;
        $this->postJson('/api/v1/reports/submit', $training)->assertOk();
        $this->assertDatabaseHas('induction_workers', ['id' => 4060, 'num_report' => 0]);
        $this->postJson('/api/v1/reports/submit', $this->body(1))->assertOk();
        $this->assertDatabaseCount('detail_induction_workers', 2);
    }
}
