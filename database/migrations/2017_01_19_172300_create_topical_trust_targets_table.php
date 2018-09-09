<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicalTrustTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topical_trust_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('target_backlink_id')->unsigned();
            $table->string('target_backlink_url');
            $table->string('topic');
            $table->integer('links')->unsigned();
            $table->tinyInteger('topical_trust_flow')->unsigned();
            $table->integer('links_from_ref_domains')->unsigned();
            $table->integer('ref_domains')->unsigned();
            $table->integer('pages')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topical_trust_targets');
    }
}
