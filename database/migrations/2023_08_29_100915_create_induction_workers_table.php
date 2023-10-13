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
        Schema::create('induction_workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_worker');
            $table->unsignedBigInteger('id_induction');
            $table->string('status');
            $table->foreign('id_worker')->references('id')->on('workers');
            $table->foreign('id_induction')->references('id')->on('inductions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('induction_workers');
    }
};
