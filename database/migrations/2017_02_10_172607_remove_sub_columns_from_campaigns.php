<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubColumnsFromCampaigns extends Migration
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
            $table->dropColumn('subscription_active');
            $table->dropColumn('subscription_referrer');
            $table->dropColumn('subscription_plan');

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
