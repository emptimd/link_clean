<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BacklinkDomainExtbacklinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //ExtBackLinks
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->integer('DomainExtBackLinks')->default(0)->after('DomainTrustFlow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->dropColumn('DomainExtBackLinks');
        });
    }
}
