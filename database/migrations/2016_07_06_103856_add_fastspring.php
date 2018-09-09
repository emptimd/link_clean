<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFastspring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fastspring_api_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->string('method', 20);
            $table->integer('campaign_id');
            $table->string('subscription_id', 255);
            $table->string('subscription_plan', 100);
            $table->json('callback');
            $table->smallInteger('seconds');
        });

        Schema::table('campaigns', function(Blueprint $table)
        {
            $table->tinyInteger('subscription_active')->default(0)->after('updated_at');
            $table->dropColumn(
                'stripe_active', 'stripe_id', 'stripe_subscription', 'stripe_plan', 'last_four', 'trial_ends_at', 'subscription_ends_at'
            );
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fastspring_api_calls');
    }
}
