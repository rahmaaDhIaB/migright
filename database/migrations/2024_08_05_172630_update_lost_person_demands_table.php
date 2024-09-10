<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLostPersonDemandsTable extends Migration
{
    /**
     * Apply the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
            $table->text('description')->nullable()->change(); // Permet les valeurs NULL
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change(); // Restaure la contrainte NOT NULL
        });
    }
}
