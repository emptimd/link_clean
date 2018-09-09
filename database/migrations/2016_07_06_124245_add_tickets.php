<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->enum('status', ['open', 'replied', 'closed']);
            $table->integer('user_id');
            $table->string('subject', 255);
        });

        Schema::create('ticket_message', function(Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->integer('ticket_id');
            $table->integer('user_id');
            $table->text('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticket', 'ticket_message');
    }
}
