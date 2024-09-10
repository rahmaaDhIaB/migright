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
            $table->enum('notification_sender', ['parent', 'friend', 'neighbor', 'other'])->nullable();
            $table->enum('missing_person_gender', ['female', 'male'])->nullable();
            $table->enum('missing_person_age', ['minor', 'adult'])->nullable();
            $table->string('nationality')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
            $table->dropColumn(['notification_sender', 'missing_person_gender', 'missing_person_age', 'nationality']);

        });
    }
};
