<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BacklinkDomainRank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->tinyInteger('DomainCitationFlow')->default(0)->after('SourceTrustFlow');
            $table->tinyInteger('DomainTrustFlow')->default(0)->after('DomainCitationFlow');
            $table->decimal('domain_rank', 5, 2)->default(0)->after('malware');
            $table->decimal('link_rank', 5, 2)->default(0)->after('domain_rank');
            $table->decimal('social_rank', 5, 2)->default(0)->after('link_rank');
            $table->decimal('total_rank', 5, 2)->default(0)->after('social_rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_backlinks', function(Blueprint $table)
        {
            $table->dropColumn('DomainCitationFlow','DomainTrustFlow','domain_rank','link_rank','social_rank','total_rank');
        });
    }
}
