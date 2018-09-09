<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetSocialMigration_20170727124516 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target_social', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->string('domain');
            $table->unsignedMediumInteger('facebook')->nullable();
            $table->unsignedMediumInteger('facebook_comments')->nullable();
            $table->unsignedMediumInteger('linkedin')->nullable();
            $table->unsignedMediumInteger('pinterest')->nullable();
            $table->unsignedMediumInteger('stumbleupon')->nullable();
            $table->unsignedMediumInteger('googleplusone')->nullable();

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
        Schema::drop('target_social');

    }
}
