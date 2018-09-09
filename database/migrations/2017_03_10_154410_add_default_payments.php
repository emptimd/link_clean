<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE payments 
        MODIFY amount DECIMAL(8,2) DEFAULT 0 NOT NULL");
        \DB::statement("ALTER TABLE ref_events 
        MODIFY cost DECIMAL(8,2) DEFAULT 0 NOT NULL,
        MODIFY revenue DECIMAL(8,2) DEFAULT 0 NOT NULL,
        MODIFY revenue_status VARCHAR(255)");
        // Subscriptions
        \DB::statement("ALTER TABLE subscriptions 
        MODIFY rebills SMALLINT(5) unsigned DEFAULT 0 NOT NULL,
        MODIFY is_active TINYINT(3) unsigned DEFAULT 0 NOT NULL");
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
