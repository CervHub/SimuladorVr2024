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
        Schema::table('detail_induction_workers', function (Blueprint $table) {
            $table->decimal('identified', 4, 1)->nullable()->change();
            $table->decimal('risk_level', 4, 1)->nullable()->change();
            $table->decimal('correct_measure', 4, 1)->nullable()->change();
            $table->string('time')->nullable()->change();
            $table->string('difficulty')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
