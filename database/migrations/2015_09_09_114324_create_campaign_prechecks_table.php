<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPrechecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_precheck', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->string('ResultCode');
            $table->string('Status');
            $table->integer('ExtBackLinks');
            $table->integer('RefDomains');
            $table->integer('AnalysisResUnitsCost');
            $table->integer('ACRank');
            $table->integer('ItemType');
            $table->integer('IndexedURLs');
            $table->integer('GetTopBackLinksAnalysisResUnitsCost');
            $table->integer('DownloadBacklinksAnalysisResUnitsCost');
            $table->integer('RefIPs');
            $table->integer('RefDomainsEDU');
            $table->integer('ExtBackLinksEDU');
            $table->integer('RefDomainsGOV');
            $table->integer('ExtBackLinksGOV');
            $table->integer('RefDomainsEDU_Exact');
            $table->integer('ExtBackLinksEDU_Exact');
            $table->integer('RefDomainsGOV_Exact');
            $table->integer('ExtBackLinksGOV_Exact');
            $table->boolean('CrawledFlag');
            $table->integer('RefSubNets');
            $table->date('LastCrawlDate');
            $table->string('LastCrawlResult');
            $table->boolean('RedirectFlag');
            $table->string('FinalRedirectResult');
            $table->integer('OutDomainsExternal');
            $table->integer('OutLinksExternal');
            $table->integer('OutLinksInternal');
            $table->date('LastSeen');
            $table->string('Title');
            $table->string('RedirectTo');
            $table->integer('CitationFlow');
            $table->integer('TrustFlow');
            $table->integer('TrustMetric');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_precheck');
    }
}
