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
            $table->string('final_note')->nullable();
            $table->string('data_report')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('induction_workers', function (Blueprint $table) {
            $table->dropColumn('final_note');
            $table->dropColumn('data_report');
        });
    }
};
