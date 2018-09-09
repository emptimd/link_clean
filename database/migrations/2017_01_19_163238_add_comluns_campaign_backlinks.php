<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComlunsCampaignBacklinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->string('SourceTopicalTrustFlow_Topic_0')->default('')->after('SourceTrustFlow');
            $table->integer('SourceTopicalTrustFlow_Value_0')->default(0)->after('SourceTopicalTrustFlow_Topic_0');
            $table->string('SourceTopicalTrustFlow_Topic_1')->default('')->after('SourceTopicalTrustFlow_Value_0');
            $table->integer('SourceTopicalTrustFlow_Value_1')->default(0)->after('SourceTopicalTrustFlow_Topic_1');
            $table->string('SourceTopicalTrustFlow_Topic_2')->default('')->after('SourceTopicalTrustFlow_Value_1');
            $table->integer('SourceTopicalTrustFlow_Value_2')->default(0)->after('SourceTopicalTrustFlow_Topic_2');
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
            $table->dropColumn('SourceTopicalTrustFlow_Topic_0');
            $table->dropColumn('SourceTopicalTrustFlow_Value_0');
            $table->dropColumn('SourceTopicalTrustFlow_Topic_1');
            $table->dropColumn('SourceTopicalTrustFlow_Value_1');
            $table->dropColumn('SourceTopicalTrustFlow_Topic_2');
            $table->dropColumn('SourceTopicalTrustFlow_Value_2');
        });
    }
}
