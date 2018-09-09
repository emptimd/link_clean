<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponseLastBulk extends Migration
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
            $table->mediumtext('response_bulk_debug')->after('response_bulk');
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
            $table->drop('response_bulk_debug');
        });    }
}
