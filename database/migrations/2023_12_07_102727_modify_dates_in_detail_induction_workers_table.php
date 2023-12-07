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
            $table->string('start_date')->change();
            $table->string('end_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('detail_induction_workers', function (Blueprint $table) {
            $table->string('start_date')->change();
            $table->string('end_date')->change();
        });
    }
};
