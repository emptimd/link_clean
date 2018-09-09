<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampId extends Migration
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
            $table->integer('campaign_id')->after('date');
        });
        Schema::table('sharedcount_api_calls', function(Blueprint $table)
        {
            $table->integer('campaign_id')->after('date');
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
            $table->dropColumn('campaign_id');
        });
        Schema::table('sharedcount_api_calls', function(Blueprint $table)
        {
            $table->dropColumn('campaign_id');
        });
    }
}
