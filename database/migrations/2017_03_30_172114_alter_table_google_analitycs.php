<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGoogleAnalitycsMigration_20170330172114 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_analitycs', function(Blueprint $table)
        {
            $table->dropColumn('url');
            $table->tinyInteger('month');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_analitycs', function(Blueprint $table)
        {
            $table->dropColumn('month');
            $table->string('url');
        });
    }
}
