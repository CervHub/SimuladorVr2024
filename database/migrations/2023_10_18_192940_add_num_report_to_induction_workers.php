<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('induction_workers', function (Blueprint $table) {
            $table->unsignedBigInteger('num_report')->default(1)->nullable();
        });
    }

    public function down()
    {
        Schema::table('induction_workers', function (Blueprint $table) {
            $table->dropColumn('num_report');
        });
    }
};
