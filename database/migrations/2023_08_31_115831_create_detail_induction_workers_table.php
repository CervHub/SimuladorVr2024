<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_induction_workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('induction_worker_id'); // Referencia a la tabla induction_workers
            $table->string('case'); // nombre del caso
            $table->decimal('identified', 3, 1); // Si fue  Identificado
            $table->decimal('risk_level', 3, 1); // Nivel de Riesgo
            $table->decimal('correct_measure', 3, 1); // Medida Correcta
            $table->string('time'); // Tiempo
            $table->string('difficulty'); // Dificultad
            $table->string('rol')->nullable();
            $table->text('json')->nullable();
            $table->timestamps();

            // Define la clave foránea
            $table->foreign('induction_worker_id')->references('id')->on('induction_workers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_induction_workers');
    }
};
