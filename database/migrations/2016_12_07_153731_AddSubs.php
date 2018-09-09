<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('subscription_plan', 50)->after('subscription_referrer');
            $table->boolean('subscription_active')->after('subscription_plan');
            $table->dateTime('subscription_change_date')->after('subscription_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn(['subscription_plan','subscription_active','subscription_change_date']);
        });
    }
}
