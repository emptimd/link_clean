<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewFieldsMajestic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('majestic_api_calls', function(Blueprint $table)
        {
            $table->dateTime('date_callback')->after('date');
            $table->string('callback', 1000)->after('response');
            $table->integer('seconds_callback')->after('seconds');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('majestic_api_calls', function(Blueprint $table)
        {
            $table->dropColumn(['date_callback','callback','seconds_callback']);
        });
    }
}
