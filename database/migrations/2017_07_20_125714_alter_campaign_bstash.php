<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBstashMigration_20170720125714 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->dropColumn('domain_rank');
            $table->dropColumn('link_rank');
            $table->dropColumn('social_rank');
            $table->dropColumn('total_rank');
            $table->dropColumn('content_count');
            $table->dropColumn('text_html_ratio');
            $table->dropColumn('anchor_ratio');
            $table->dropColumn('outgoing_backlinks');
            $table->dropColumn('domain_zone_ratio');
            $table->dropColumn('unreachable');
            $table->dropColumn('page_load_time');
            $table->dropColumn('count_external_links_sidebar_footer');
            $table->dropColumn('FlagRedirect');

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
            $table->tinyInteger('FlagRedirect');
            $table->decimal('domain_rank', 5, 2)->default(0);
            $table->decimal('link_rank', 5, 2)->default(0);
            $table->decimal('social_rank', 5, 2)->default(0);
            $table->decimal('total_rank', 5, 2)->default(0);
            $table->integer('content_count');
            $table->decimal('text_html_ratio', 3, 3);
            $table->decimal('anchor_ratio', 3, 3);
            $table->integer('outgoing_backlinks');
            $table->integer('domain_zone_ratio')->default(50);
            $table->boolean('unreachable');
            $table->decimal('page_load_time', 5, 2)->default(0);
            $table->integer('count_external_links_sidebar_footer')->default(0);
        });
    }
}
