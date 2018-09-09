<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlanalyzerColumns2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('urlanalyzer_api_calls', function(Blueprint $table)
//        {
//            $table->boolean('processed')->after('seconds_callback');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('urlanalyzer_api_calls', function(Blueprint $table)
//        {
//            $table->drop('processed');
//        });
    }
}
