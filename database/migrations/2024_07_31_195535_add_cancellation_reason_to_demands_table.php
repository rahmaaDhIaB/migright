<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cancellation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        if (Schema::hasTable('cancellation_reasons')) {
            Schema::table('demands', function (Blueprint $table) {
                $table->foreignId('cancellation_reason_id')->nullable()->constrained('cancellation_reasons');
            });
        }
    }

    public function down()
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->dropForeign(['cancellation_reason_id']);
            $table->dropColumn('cancellation_reason_id');
        });
    }
};
