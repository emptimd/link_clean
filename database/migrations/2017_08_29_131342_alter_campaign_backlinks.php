<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBacklinksMigration_20170829131342 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->dropColumn('TargetCitationFlow');
            $table->dropColumn('TargetTrustFlow');
            $table->tinyInteger('paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->tinyInteger('TargetCitationFlow')->default(0);
            $table->tinyInteger('TargetTrustFlow')->default(0);
            $table->dropColumn('paid');
        });
    }
}
