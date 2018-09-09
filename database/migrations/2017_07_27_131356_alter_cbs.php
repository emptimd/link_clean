<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCbsMigration_20170727131356 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->unsignedInteger('domain_id');

            $table->dropColumn('DomainCitationFlow');
            $table->dropColumn('DomainTrustFlow');
            $table->dropColumn('DomainExtBackLinks');
            $table->dropColumn('country');
            $table->dropColumn('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->dropColumn('domain_id');

            $table->unsignedTinyInteger('DomainCitationFlow');
            $table->unsignedTinyInteger('DomainTrustFlow');
            $table->unsignedInteger('DomainExtBackLinks');
            $table->char('country', 2);
            $table->unsignedInteger('ip');
        });
    }
}
