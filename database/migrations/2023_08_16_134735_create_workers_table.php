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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('code_worker');
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_service');
            $table->string('position')->nullable();
            $table->string('status')->default('1');
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_company')->references('id')->on('companies');
            $table->foreign('id_service')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
