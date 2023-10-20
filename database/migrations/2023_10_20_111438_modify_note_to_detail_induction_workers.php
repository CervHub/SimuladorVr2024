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
            $table->decimal('note', 3, 1)->change();
            $table->decimal('note_reference', 3, 1)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_induction_workers', function (Blueprint $table) {
            //
        });
    }
};
