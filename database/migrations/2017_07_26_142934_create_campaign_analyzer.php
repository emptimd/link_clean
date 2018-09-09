<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignAnalyzerMigration_20170726142934 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_analyzer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedMediumInteger('content_count');
            $table->decimal('text_html_ratio', 6, 3)->default(0);
            $table->decimal('anchor_ratio', 5, 3)->default(0);
            $table->unsignedMediumInteger('outgoing_backlinks');
            $table->decimal('page_load_time', 5, 2)->default(0);
            $table->tinyInteger('unreachable');

//            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_analyzer');
    }
}
