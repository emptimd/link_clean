<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampaignBacklinksColumn2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('campaign_backlinks', function(Blueprint $table)
//        {
//            $table->boolean('malware')->after('unreachable');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('campaign_backlinks', function(Blueprint $table)
//        {
//            $table->drop('malware');
//        });
    }
}
