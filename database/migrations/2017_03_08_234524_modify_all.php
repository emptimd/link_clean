<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('majestic_api_calls', function(Blueprint $table) {
            $table->dropColumn('date_callback');
        });

        Schema::table('majestic_api_calls', function(Blueprint $table) {
            $table->string('callback')->nullable()->change();
            $table->timestamp('date_callback')->nullable();
        });

        \DB::statement("ALTER TABLE majestic_api_calls
        MODIFY response TEXT");

        \DB::statement("ALTER TABLE majestic_api_calls
        CHANGE callback callback VARCHAR(255)");

        \DB::statement("ALTER TABLE majestic_api_calls
        MODIFY processed TINYINT(4) DEFAULT 0");

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
