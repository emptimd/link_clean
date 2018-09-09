<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProcessed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('majestic_api_calls', function(Blueprint $table)
        {
            $table->boolean('processed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('majestic_api_calls', function(Blueprint $table)
        {
            $table->drop('processed');
        });
    }
}
