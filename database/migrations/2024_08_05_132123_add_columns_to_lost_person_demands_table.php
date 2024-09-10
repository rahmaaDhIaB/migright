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
        Schema::table('lost_person_demands', function (Blueprint $table) {
            $table->string('group_type')->nullable(); 
            $table->integer('number_of_missing_persons')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
            $table->dropColumn(['group_type', 'number_of_missing_persons']);
        });
    }
};
