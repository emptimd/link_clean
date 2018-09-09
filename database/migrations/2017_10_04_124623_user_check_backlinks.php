<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCheckBacklinksMigration_20171004124623 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_check_backlinks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('url');
            $table->string('target_url');
            $table->string('anchor_text');
            $table->tinyInteger('no_follow')->default(0);
            /*Domain Info*/
            $table->unsignedTinyInteger('DomainCitationFlow')->default(0);
            $table->unsignedTinyInteger('DomainTrustFlow')->default(0);
            $table->unsignedInteger('DomainExtBackLinks')->default(0);
//            $table->char('country', 2);
            $table->unsignedInteger('ip')->default(0);
            $table->decimal('domain_rank', 5, 2)->default(0);
            /*Social rank*/
            $table->decimal('social_rank', 5, 2)->default(0);
            $table->decimal('total_rank', 5, 2)->default(0);
            $table->decimal('referral_influence', 5, 2)->default(0);


            $table->tinyInteger('is_published')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_check_backlinks');
    }
}
