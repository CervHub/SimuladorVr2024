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
        Schema::create('inductions', function (Blueprint $table) {
            $table->id();
            $table->date('date_start'); // Fecha de inicio
            $table->time('time_start'); // Hora de inicio
            $table->date('date_end');   // Fecha de fin
            $table->time('time_end');   // Hora de fin
            $table->integer('nota_referencial')->nullable();
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_workshop');
            $table->string('status');
            $table->foreign('id_company')->references('id')->on('companies');
            $table->foreign('id_workshop')->references('id')->on('workshops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inductions');
    }
};
