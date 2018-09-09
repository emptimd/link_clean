<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCbMigration_20170727125828 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->unsignedInteger('domain_id');

            $table->dropColumn('DomainCitationFlow');
            $table->dropColumn('DomainTrustFlow');
            $table->dropColumn('DomainExtBackLinks');
            $table->dropColumn('country');
            $table->dropColumn('ip');
            $table->dropColumn('domain_rank');

            $table->dropColumn('content_count');
            $table->dropColumn('text_html_ratio');
            $table->dropColumn('anchor_ratio');
            $table->dropColumn('outgoing_backlinks');
            $table->dropColumn('page_load_time');
            $table->dropColumn('social_rank');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks', function (Blueprint $table) {
            $table->dropColumn('domain_id');

            $table->unsignedTinyInteger('DomainCitationFlow');
            $table->unsignedTinyInteger('DomainTrustFlow');
            $table->unsignedInteger('DomainExtBackLinks');
            $table->char('country', 2);
            $table->unsignedInteger('ip');

            $table->decimal('domain_rank', 5, 2)->default(0);
            $table->decimal('social_rank', 5, 2)->default(0);
            $table->integer('content_count');
            $table->decimal('text_html_ratio', 3, 3);
            $table->decimal('anchor_ratio', 3, 3);
            $table->integer('outgoing_backlinks');
            $table->decimal('page_load_time', 5, 2)->default(0);
        });
    }
}
