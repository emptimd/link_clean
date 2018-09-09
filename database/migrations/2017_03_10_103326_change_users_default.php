<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE users 
  MODIFY campaigns TINYINT unsigned DEFAULT 0 NOT NULL,
  MODIFY backlinks MEDIUMINT unsigned DEFAULT 0 NOT NULL,
  MODIFY backlinks_used INT unsigned DEFAULT 0 NOT NULL,
  MODIFY balance DECIMAL(8,2) DEFAULT 0 NOT NULL,
  MODIFY paypal_email VARCHAR(255),
  MODIFY promocode VARCHAR(50)");

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
