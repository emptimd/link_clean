<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChagngeEngagedCountLastUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('engagedcount_api_calls', function (Blueprint $table) {
            $table->dropColumn('last_update');
        });

        Schema::table('engagedcount_api_calls', function (Blueprint $table) {
            $table->dateTime('last_update')->after('campaign_id')->nullable();
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
