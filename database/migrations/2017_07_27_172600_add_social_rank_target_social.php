<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialRankTargetSocialMigration_20170727172600 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('target_social', function (Blueprint $table) {
            $table->decimal('social_rank', 5, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('target_social', function (Blueprint $table) {
            $table->dropColumn('social_rank');
        });
    }
}
