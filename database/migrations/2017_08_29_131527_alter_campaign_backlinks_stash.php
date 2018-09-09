<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBacklinksStashMigration_20170829131527 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->dropColumn('TargetCitationFlow');
            $table->dropColumn('TargetTrustFlow');
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
            $table->tinyInteger('TargetCitationFlow')->default(0);
            $table->tinyInteger('TargetTrustFlow')->default(0);
        });
    }
}
