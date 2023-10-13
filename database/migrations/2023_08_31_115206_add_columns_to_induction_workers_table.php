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
        Schema::table('induction_workers', function (Blueprint $table) {
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->decimal('note', 3, 1)->nullable(); // Nota numérica
            $table->string('shift')->nullable();
            $table->integer('case_count')->nullable();
            $table->decimal('reference_note', 3, 1)->nullable(); // Nota de referencia
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('induction_workers', function (Blueprint $table) {
            //
        });
    }
};
