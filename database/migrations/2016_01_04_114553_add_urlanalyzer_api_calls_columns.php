<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlanalyzerApiCallsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urlanalyzer_api_calls', function(Blueprint $table)
        {
            $table->timestamp('date_callback')->after('date');
            $table->integer('seconds_callback')->after('seconds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urlanalyzer_api_calls', function(Blueprint $table)
        {
            $table->drop('date_callback');
            $table->drop('seconds_callback');
        });
    }
}
