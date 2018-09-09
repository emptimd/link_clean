<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Remove2MoreColumnsFromCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //remove columns
        Schema::table('campaigns', function(Blueprint $table) {
            $table->dropColumn('domain_rank');
            $table->dropColumn('social_rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
