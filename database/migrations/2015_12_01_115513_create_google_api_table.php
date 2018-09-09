<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_api_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date');
            $table->integer('campaign_id');
            $table->string('method', 100);
            $table->text('request');
            $table->mediumText('response');
            $table->integer('seconds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('google_api_calls');
    }
}
