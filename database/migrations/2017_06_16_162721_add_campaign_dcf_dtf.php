<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampaignDcfDtfMigration_20170616162721 extends Migration
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
            $table->unsignedTinyInteger('citation_flow')->default(0);
            $table->unsignedTinyInteger('trust_flow')->default(0);
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
            $table->dropColumn('citation_flow');
            $table->dropColumn('trust_flow');
        });
    }
}
