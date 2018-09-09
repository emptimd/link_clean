<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedcountApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharedcount_api_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date');
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
        Schema::drop('sharedcount_api_calls');
    }
}
