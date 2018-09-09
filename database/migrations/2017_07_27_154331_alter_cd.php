<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCdMigration_20170727154331 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_domains', function (Blueprint $table) {
            $table->string('domain');
            $table->dropColumn('DomainCitationFlow');
            $table->dropColumn('DomainTrustFlow');
            $table->dropColumn('DomainExtBackLinks');

            $table->unsignedTinyInteger('CitationFlow');
            $table->unsignedTinyInteger('TrustFlow');
            $table->unsignedInteger('ExtBackLinks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_domains', function (Blueprint $table) {
            $table->dropColumn('domain');
            $table->dropColumn('CitationFlow');
            $table->dropColumn('TrustFlow');
            $table->dropColumn('ExtBackLinks');

            $table->unsignedTinyInteger('DomainCitationFlow');
            $table->unsignedTinyInteger('DomainTrustFlow');
            $table->unsignedInteger('DomainExtBackLinks');
        });
    }
}
