<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * "refused" was a legitimate workflow state but was missing from the column
     * enum, so refusals were silently stored as "done" or coerced to "pending".
     */
    public function up(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in progress', 'done', 'refused', 'cancelled'])->default('pending')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in progress', 'done', 'cancelled'])->default('pending')->nullable()->change();
        });
    }
};
