<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketBacklinksMigration_20170829130611 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_backlinks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('market_id');
            $table->string('url');
            $table->string('target_url');
            $table->string('anchor_text');
            $table->tinyInteger('follow');
            $table->timestamps();
            $table->foreign('market_id')->references('id')->on('market')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('market_backlinks');
    }
}
