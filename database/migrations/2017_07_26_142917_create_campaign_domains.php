<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignDomainsMigration_20170726142917 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('campaign_domains', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('campaign_id');
                $table->unsignedTinyInteger('DomainCitationFlow');
                $table->unsignedTinyInteger('DomainTrustFlow');
                $table->unsignedInteger('DomainExtBackLinks');
                $table->char('country', 2);
                $table->unsignedInteger('ip');
                $table->decimal('domain_rank', 5, 2)->default(0);
//                $table->unsignedSmallInteger('recheck_nr');

                $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_domains');
    }
}
