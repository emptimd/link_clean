<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignAnchorsMigration_20170615154357 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_anchors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->string('anchor');
            $table->unsignedInteger('ref_domains');
            $table->unsignedInteger('total_links');
            $table->unsignedInteger('deleted_links');
            $table->unsignedInteger('nofollow_links');
            $table->decimal('percent', 5, 2)->default(0);

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
        Schema::drop('campaign_anchors');
    }
}
