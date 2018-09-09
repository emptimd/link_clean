<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTopicalTrustTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topical_trust_targets', function(Blueprint $table) {
            $table->dropColumn('target_backlink_id');
            $table->unsignedInteger('campaign_id')->after('id')->nullable();
            $table->index('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
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
