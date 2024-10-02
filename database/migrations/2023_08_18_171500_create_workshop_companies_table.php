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
        Schema::create('workshop_companies', function (Blueprint $table) {
            $table->id();
            $table->string('alias');
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
        Schema::dropIfExists('workshop_companies');
    }
};
