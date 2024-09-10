<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToLostPersonDemandsTable extends Migration
{
    public function up()
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
           
            $table->text('description');
        });
    }

    public function down()
    {
        Schema::table('lost_person_demands', function (Blueprint $table) {
          
        
            $table->dropColumn('description');
        });
    }
}
