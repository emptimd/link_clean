<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('campaign_id');
            $table->integer('total_backlinks');
            $table->integer('backlinks_good');
            $table->integer('backlinks_bad');
            $table->integer('penalty_risk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_summaries');
    }
}
