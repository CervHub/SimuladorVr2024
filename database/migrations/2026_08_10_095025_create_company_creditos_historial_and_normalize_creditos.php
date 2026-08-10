<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Normalizar creditos a entero (default 0)
        DB::statement("UPDATE companies SET creditos = '0' WHERE creditos IS NULL OR creditos = '' OR creditos !~ '^[0-9]+$'");
        DB::statement('ALTER TABLE companies ALTER COLUMN creditos TYPE integer USING COALESCE(creditos::integer, 0)');
        DB::statement('ALTER TABLE companies ALTER COLUMN creditos SET DEFAULT 0');
        DB::statement('ALTER TABLE companies ALTER COLUMN creditos SET NOT NULL');

        Schema::create('company_creditos_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_company');
            $table->integer('creditos_anteriores')->default(0);
            $table->integer('creditos_nuevos')->default(0);
            $table->integer('diferencia')->default(0);
            $table->string('tipo')->default('actualizacion'); // asignacion | actualizacion | consumo
            $table->string('origen')->nullable(); // admin | api
            $table->string('observacion')->nullable();
            $table->timestamps();

            $table->foreign('id_company')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_creditos_historial');

        DB::statement('ALTER TABLE companies ALTER COLUMN creditos DROP NOT NULL');
        DB::statement('ALTER TABLE companies ALTER COLUMN creditos DROP DEFAULT');
        DB::statement('ALTER TABLE companies ALTER COLUMN creditos TYPE varchar(255) USING creditos::varchar');
    }
};
