<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignBacklinksStash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_backlinks_stash', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->string('SourceURL');
            $table->integer('ACRank');
            $table->string('AnchorText');
            $table->date('Date');
            $table->integer('FlagRedirect');
            $table->integer('FlagFrame');
            $table->integer('FlagNoFollow');
            $table->integer('FlagImages');
            $table->integer('FlagAltText');
            $table->integer('FlagMention');
            $table->string('TargetURL');
            $table->date('FirstIndexedDate');
            $table->integer('TargetCitationFlow');
            $table->integer('TargetTrustFlow');
            $table->integer('SourceCitationFlow');
            $table->integer('SourceTrustFlow');

            $table->tinyInteger('DomainCitationFlow')->default(0);
            $table->tinyInteger('DomainTrustFlow')->default(0);
            $table->decimal('domain_rank', 5, 2)->default(0);
            $table->decimal('link_rank', 5, 2)->default(0);
            $table->decimal('social_rank', 5, 2)->default(0);
            $table->decimal('total_rank', 5, 2)->default(0);
            $table->integer('DomainExtBackLinks')->default(0);

            $table->integer('content_count');
            $table->decimal('text_html_ratio', 3, 3);
            $table->decimal('anchor_ratio', 3, 3);
            $table->integer('outgoing_backlinks');
            $table->integer('domain_zone_ratio')->default(50);

            $table->boolean('unreachable');
            $table->boolean('malware');

            $table->decimal('page_load_time', 5, 2)->default(0);
            $table->integer('count_external_links_sidebar_footer')->default(0);

            $table->index('campaign_id');
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
        Schema::drop('campaign_backlinks_stash');
    }
}
