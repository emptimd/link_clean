<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBacklinksMigration_20170720132003 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->dropColumn('count_external_links_sidebar_footer');
            $table->dropColumn('domain_zone_ratio');
            $table->dropColumn('FlagRedirect');
            $table->smallInteger('http_code');
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
            $table->tinyInteger('FlagRedirect');
            $table->integer('count_external_links_sidebar_footer')->default(0);
            $table->integer('domain_zone_ratio')->default(50);
            $table->dropColumn('http_code');
        });
    }
}
