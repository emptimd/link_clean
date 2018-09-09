<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertDomainSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domain_social', function(Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->unsignedSmallInteger('recheck_nr')->default(0);
            $table->unsignedInteger('campaign_id')->after('id')->nullable();

            $table->index('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });

        \DB::table('campaigns')->whereRaw('deleted=1')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domain_social', function(Blueprint $table) {
            $table->dropIndex('campaign_id');
            $table->dropForeign('domain_social_campaign_id_index');
            $table->dropColumn('recheck_nr');
            $table->dropColumn('campaign_id');

            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }
}
