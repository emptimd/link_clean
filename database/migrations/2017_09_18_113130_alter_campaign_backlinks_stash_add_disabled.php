<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBacklinksStashAddDisabledMigration_20170918113130 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->tinyInteger('is_disabled')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });
    }
}
