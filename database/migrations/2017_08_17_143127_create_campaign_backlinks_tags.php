<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignBacklinksTagsMigration_20170817143127 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_backlinks_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('backlink_id');
            $table->string('tag');

            $table->foreign('backlink_id')->references('id')->on('campaign_backlinks')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_backlinks_tags');
    }
}
