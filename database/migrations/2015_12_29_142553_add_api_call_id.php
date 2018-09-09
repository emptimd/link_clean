<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiCallId extends Migration
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
            $table->integer('api_call_id')->after('callback');
            $table->index('api_call_id');
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
            $table->dropColumn('api_call_id');
        });
    }
}
