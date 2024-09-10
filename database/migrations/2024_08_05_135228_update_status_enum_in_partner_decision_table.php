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
        Schema::table('partner_decision', function (Blueprint $table) {
            $table->enum('status', ['closed', 'awaiting', 'accepted', 'refused'])
                ->default('awaiting')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_decision', function (Blueprint $table) {
            $table->enum('status', ['closed', 'pending', 'accepted', 'refused'])
                ->default('pending')
                ->change();
        });
    }
};
