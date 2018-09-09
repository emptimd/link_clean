<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignBacklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_backlinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->string('SourceURL');
            $table->integer('ACRank');
            $table->string('AnchorText');
            $table->date('Date');
            $table->integer('FlagRedirect');
            $table->integer('FlagFrame');
            $table->integer('FlagNoFollow');
            $table->integer('FlagImages');
            $table->integer('FlagDeleted');
            $table->integer('FlagAltText');
            $table->integer('FlagMention');
            $table->string('TargetURL');
            $table->integer('DomainID');
            $table->date('FirstIndexedDate');
            $table->date('LastSeenDate');
            $table->date('DateLost');
            $table->string('ReasonLost');
            $table->string('LinkType');
            $table->string('LinkSubType');
            $table->integer('TargetCitationFlow');
            $table->integer('TargetTrustFlow');
            $table->integer('SourceCitationFlow');
            $table->integer('SourceTrustFlow');
            $table->timestamps();
        });

//        +"SourceURL": "http://www.iowafarmbureau.com/privacypolicy.aspx"
//        +"ACRank": 0
//        +"AnchorText": "http://www.fb.com"
//        +"Date": "2012-04-18"
//        +"FlagRedirect": 0
//        +"FlagFrame": 0
//        +"FlagNoFollow": 0
//        +"FlagImages": 0
//        +"FlagDeleted": 0
//        +"FlagAltText": 0
//        +"FlagMention": 0
//        +"TargetURL": "http://fb.com/"
//        +"DomainID": -1
//        +"FirstIndexedDate": "2012-04-18"
//        +"LastSeenDate": "2012-04-18"
//        +"DateLost": ""
//        +"ReasonLost": ""
//        +"LinkType": "TextLink"
//        +"LinkSubType": "TextLink_Normal_HighContent"
//        +"TargetCitationFlow": 0
//        +"TargetTrustFlow": 0
//        +"SourceCitationFlow": 0
//        +"SourceTrustFlow": 0
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_backlinks');
    }
}
