<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaltValuesCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Users Table
        \DB::statement("ALTER TABLE users MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Campaigns Table
        \DB::statement("ALTER TABLE campaigns MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY stage TINYINT DEFAULT 0 NOT NULL,
  MODIFY stage_status TINYINT DEFAULT 0 NOT NULL");


        // Campaign Summaries
        \DB::statement("ALTER TABLE campaign_summaries MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Engaged count api
        \DB::statement("ALTER TABLE engagedcount_api_calls MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Google api calls
        \DB::statement("ALTER TABLE google_api_calls MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Majestic api calls (remove response field)
        \DB::statement("ALTER TABLE majestic_api_calls MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");


        // Password resets
        \DB::statement("ALTER TABLE password_resets MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Payments
        \DB::statement("ALTER TABLE payments MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Ref Events
        \DB::statement("ALTER TABLE ref_events MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Referrals
        \DB::statement("ALTER TABLE referrals MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Shard count api (mb rm this table)
        \DB::statement("ALTER TABLE sharedcount_api_calls MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Subscriptions
        \DB::statement("ALTER TABLE subscriptions MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Tickets
        \DB::statement("ALTER TABLE ticket MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");

        // Urlanalizer api calls
        \DB::statement("ALTER TABLE urlanalyzer_api_calls MODIFY date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  MODIFY date_callback TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL");


//        Schema::table('campaigns', function(Blueprint $table) {
////            $table->timestamp('date');
//            $table->tinyInteger('stage')->default(0)->change();
//            $table->tinyInteger('stage_status')->default(0)->change();
////            $table->tinyInteger('test')->default(50);
////            $table->dropColumn('test');
//        });

        Schema::table('majestic_api_calls', function(Blueprint $table) {
            $table->dropColumn('seconds');
            $table->dropColumn('seconds_callback');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
