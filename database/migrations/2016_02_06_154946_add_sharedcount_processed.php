<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSharedcountProcessed extends Migration
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
            $table->mediumText('response_bulk')->after('response');
            $table->integer('seconds_response_bulk')->after('seconds');
            $table->boolean('processed')->after('seconds_response_bulk');
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
            $table->drop('response_bulk', 'seconds_response_bulk', 'processed');
        });
    }
}
