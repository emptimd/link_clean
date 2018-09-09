<?php

use App\CampaignBacklink;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDecimalCampaignBacklinksMigration_20170316144213 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \DB::statement("ALTER TABLE campaign_backlinks 
        MODIFY text_html_ratio DECIMAL(5,3) DEFAULT 0.000 NOT NULL,
        MODIFY anchor_ratio DECIMAL(5,3) DEFAULT 0.000 NOT NULL");
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
