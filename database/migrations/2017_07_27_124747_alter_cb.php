<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCbMigration_20170727124747 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE campaign_backlinks MODIFY ACRank TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY FlagFrame TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY FlagNoFollow TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY FlagImages TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY FlagAltText TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY FlagMention TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY TargetCitationFlow TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY TargetTrustFlow TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY SourceCitationFlow TINYINT unsigned DEFAULT 0 NOT NULL,
        MODIFY SourceTrustFlow TINYINT unsigned DEFAULT 0 NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
