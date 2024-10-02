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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('departamento_id'); // Clave foránea
            $table->timestamps();

            $table->foreign('departamento_id') // Especifica la clave foránea
                ->references('id') // La columna en la tabla departamentos
                ->on('departamentos') // La tabla a la que hace referencia
                ->onDelete('cascade'); // Qué hacer cuando se elimina el departamento
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
