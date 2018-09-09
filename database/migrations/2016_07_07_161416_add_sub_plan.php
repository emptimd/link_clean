<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubPlan extends Migration
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
            $table->string('subscription_plan', 100)->after('subscription_referrer');
        });

        Schema::table('fastspring_api_calls', function(Blueprint $table)
        {
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
        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->dropColumn('subscription_plan');
        });
    }
}
