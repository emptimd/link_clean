<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBacklinksAddIdCountryMigration_20170525165006 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function(Blueprint $table)
        {
            $table->char('country', 2)->default('');
            $table->unsignedInteger('ip')->default(0);
        });

        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->char('country', 2)->default('');
            $table->unsignedInteger('ip')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks_stash', function(Blueprint $table)
        {
            $table->dropColumn('country');
            $table->dropColumn('ip');
        });

        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->dropColumn('country');
            $table->dropColumn('ip');
        });
    }
}
