<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCampaignPrecheckColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Users Table
        \DB::statement("ALTER TABLE campaign_precheck MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        Schema::table('campaign_precheck', function (Blueprint $table) {
            $table->dropColumn('RefDomainsEDU');
            $table->dropColumn('ExtBackLinksEDU');
            $table->dropColumn('RefDomainsGOV');
            $table->dropColumn('ExtBackLinksGOV');
            $table->dropColumn('RefDomainsEDU_Exact');
            $table->dropColumn('ExtBackLinksEDU_Exact');
            $table->dropColumn('RefDomainsGOV_Exact');
            $table->dropColumn('ExtBackLinksGOV_Exact');
            $table->dropColumn('RefSubNets');
            $table->dropColumn('LastCrawlDate');
            $table->dropColumn('LastCrawlResult');
            $table->dropColumn('LastSeen');
        });

        Schema::table('campaign_precheck', function (Blueprint $table) {
            $table->date('LastSeen')->after('OutLinksInternal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
