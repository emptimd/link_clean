<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSomeUselessFromEngagedcountMigration_20170711153037 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('engagedcount_api_calls', function(Blueprint $table)
        {
            $table->dropColumn('method');
            $table->dropColumn('request');
            $table->dropColumn('response');
            $table->dropColumn('response_bulk');
            $table->dropColumn('response_bulk_debug');
            $table->dropColumn('seconds');
            $table->dropColumn('seconds_response_bulk');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('engagedcount_api_calls', function(Blueprint $table)
//        {
//            $table->unsignedSmallInteger('http_code')->default(200)->after('ip');
//        });
    }
}
