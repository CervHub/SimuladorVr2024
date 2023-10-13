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
        Schema::table('inductions', function (Blueprint $table) {
            $table->unsignedBigInteger('id_worker');
            $table->foreign('id_worker')->references('id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inductions', function (Blueprint $table) {
            //
        });
    }
};
