<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDomainSocialMigration_20170727131727 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('domain_social');

        Schema::create('domain_social', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedMediumInteger('facebook')->nullable();
            $table->unsignedMediumInteger('facebook_comments')->nullable();
            $table->unsignedMediumInteger('linkedin')->nullable();
            $table->unsignedMediumInteger('pinterest')->nullable();
            $table->unsignedMediumInteger('stumbleupon')->nullable();
            $table->unsignedMediumInteger('googleplusone')->nullable();
            $table->decimal('social_rank', 5, 2);

            $table->primary('id');
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
//        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
//            $table->dropColumn('DomainCitationFlow');
//            $table->dropColumn('DomainTrustFlow');
//            $table->dropColumn('DomainExtBackLinks');
//            $table->dropColumn('country');
//            $table->dropColumn('ip');
//        });
    }
}
