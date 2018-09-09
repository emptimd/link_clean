<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_social', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('domain')->unique()->index();
            $table->integer('facebook')->nullable();
            $table->integer('facebook_comments')->nullable();
            $table->integer('linkedin')->nullable();
            $table->integer('pinterest')->nullable();
            $table->integer('stumbleupon')->nullable();
            $table->integer('googleplusone')->nullable();
            $table->boolean('to_update')->default(0);
            $table->string('bulk_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('domain_social');
    }
}
