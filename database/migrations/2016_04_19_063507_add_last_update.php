<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sharedcount_api_calls', function(Blueprint $table)
        {
            $table->dateTime('last_update')->after('date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sharedcount_api_calls', function(Blueprint $table)
        {
            $table->drop('last_update');
        });
    }
}
