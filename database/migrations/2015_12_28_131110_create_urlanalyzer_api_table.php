<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlanalyzerApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urlanalyzer_api_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date');
            $table->string('method', 100);
            $table->longText('request');
            $table->longText('response');
            $table->longText('callback');
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
        Schema::drop('urlanalyzer_api_calls');
    }
}
