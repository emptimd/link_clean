<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCampaignIdFromFastspringApiCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fastspring_api_calls', function (Blueprint $table) {
            $table->dropColumn('seconds');
            $table->integer('campaign_id')->nullable()->default(0)->change();
            $table->string('subscription_id')->default("")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fastspring_api_calls', function (Blueprint $table) {
            $table->integer('seconds');
        });
    }
}
