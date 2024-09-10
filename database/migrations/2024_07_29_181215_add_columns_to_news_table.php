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
        Schema::table('news', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->renameColumn('title','title_en');
            $table->renameColumn('description','description_en');
            $table->string('title_fr')->nullable();
            $table->text('description_fr')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            //
        });
    }
};
