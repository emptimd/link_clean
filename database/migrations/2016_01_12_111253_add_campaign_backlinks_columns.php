<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampaignBacklinksColumns extends Migration
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
            $table->integer('content_count')->after('SourceTrustFlow');
            $table->decimal('text_html_ratio', 3, 3)->after('content_count');
            $table->decimal('anchor_ratio', 3, 3)->after('text_html_ratio');
            $table->integer('outgoing_backlinks')->after('anchor_ratio');
            $table->integer('domain_zone_ratio')->default(50)->after('outgoing_backlinks');
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
            $table->drop('content_count');
            $table->drop('text_html_ratio');
            $table->drop('anchor_ratio');
            $table->drop('outgoing_backlinks');
            $table->drop('domain_zone_ratio');
        });
    }
}
