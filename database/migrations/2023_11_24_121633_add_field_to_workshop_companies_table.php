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
        Schema::table('workshop_companies', function (Blueprint $table) {
            $table->decimal('pondered_note', 8, 2)->nullable();
            $table->decimal('minimum_passing_note', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('workshop_companies', function (Blueprint $table) {
            $table->dropColumn('pondered_note');
            $table->dropColumn('minimum_passing_note');
        });
    }
};
