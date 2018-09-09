<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampaignColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->tinyInteger('stage')->after('social_rank');
            $table->tinyInteger('stage_status')->after('stage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->drop('stage');
            $table->drop('stage_status');
        });
    }
}
