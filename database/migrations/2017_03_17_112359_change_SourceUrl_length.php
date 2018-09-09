<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSourceUrlLengthMigration_20170317112359 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks_stash', function (Blueprint $table) {
            $table->string('SourceURL', 1000)->change();
        });

        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->string('SourceURL', 1000)->change();
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
