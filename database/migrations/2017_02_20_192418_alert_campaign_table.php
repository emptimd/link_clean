<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('campaigns', function(Blueprint $table) {
            $table->dropColumn('deleted');
            $table->unsignedSmallInteger('recheck_nr')->default(0);
            $table->tinyInteger('to_recheck')->default(0);
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
