<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndex extends Migration
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
            $table->index('campaign_id');
        });
        Schema::table('campaign_precheck', function(Blueprint $table)
        {
            $table->index('campaign_id');
        });
        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->index('user_id');
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
            $table->dropIndex('campaign_id');
        });
        Schema::table('campaign_precheck', function(Blueprint $table)
        {
            $table->dropIndex('campaign_id');
        });
        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->dropIndex('user_id');
        });
    }
}
