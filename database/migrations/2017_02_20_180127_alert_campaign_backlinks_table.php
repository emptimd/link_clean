<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertCampaignBacklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // remove this from prod, because we do not have this campaigns.
//        \DB::table('campaign_backlinks')->whereIn('campaign_id', [254, 337])->delete();

        Schema::table('campaign_backlinks', function(Blueprint $table) {
//            $table->dropColumn('FlagDeleted');
//            $table->dropColumn('DomainID');
//            $table->dropColumn('LastSeenDate');
//            $table->dropColumn('DateLost');
//            $table->dropColumn('ReasonLost');
//            $table->dropColumn('LinkType');
//            $table->dropColumn('LinkSubType');
//            $table->unsignedSmallInteger('recheck_nr')->default(0);
//            $table->unsignedInteger('campaign_id')->change();

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
        Schema::table('campaign_backlinks', function(Blueprint $table) {
            $table->dropForeign('campaign_backlinks_campaign_id_index');
            $table->dropColumn('recheck_nr');
            $table->dropColumn('campaign_id');
        });
    }
}
