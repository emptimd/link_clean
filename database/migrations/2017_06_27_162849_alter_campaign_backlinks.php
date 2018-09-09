<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampaignBacklinksMigration_20170627162849 extends Migration
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
//            $table->dropColumn('social_rank');
//            $table->dropColumn('unreachable');
            $table->unsignedSmallInteger('http_code')->default(200)->after('ip');
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
            $table->dropColumn('http_code');
//            $table->decimal('social_rank', 5, 2);
//            $table->tinyInteger('unreachable');
        });
    }
}
