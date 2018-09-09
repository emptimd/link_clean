<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlanalyzerColumns extends Migration
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
            $table->integer('campaign_id')->after('date_callback');
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
            $table->drop('campaign_id');
        });
    }
}
