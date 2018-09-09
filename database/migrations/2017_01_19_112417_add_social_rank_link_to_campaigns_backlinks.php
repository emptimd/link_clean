<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialRankLinkToCampaignsBacklinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->decimal('social_rank_link', 5, 2)->default(0)->after('social_rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->dropColumn('social_rank_link');
        });
    }
}
