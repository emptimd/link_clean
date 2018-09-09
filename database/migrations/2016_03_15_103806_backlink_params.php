<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BacklinkParams extends Migration
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
            $table->decimal('page_load_time', 5, 2)->default(0)->after('domain_zone_ratio');
            $table->integer('count_external_links_sidebar_footer')->default(0)->after('page_load_time');
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
            $table->drop('page_load_time');
            $table->drop('count_external_links_sidebar_footer');
        });
    }
}
