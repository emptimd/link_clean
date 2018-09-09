<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetrys extends Migration
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
            $table->tinyInteger('retries')->default(0);
            $table->tinyInteger('error')->default(0);
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
            $table->drop('retries', 'error');
        });
    }
}
