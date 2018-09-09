<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAndRemoveUrlanalizer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urlanalyzer_api_calls', function(Blueprint $table) {
//            $table->dropColumn('seconds');
//            $table->dropColumn('seconds_callback');
            $table->dropColumn('date_callback');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
