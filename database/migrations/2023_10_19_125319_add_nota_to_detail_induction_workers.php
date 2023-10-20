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
            $table->unsignedBigInteger('note')->nullable();
            $table->unsignedBigInteger('note_reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_induction_workers', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('note_reference');
        });
    }
};
