<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedColumnsFromUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Every user that has credits gains 3 campaings and 50k backlins
        $users = User::where('credits', '<>', 0)->get();
        foreach($users as $user) {
            $user->campaigns += 3;
            $user->backlinks += 50000;
            $user->save();
        }
        //remove columns
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('credits');
            $table->dropColumn('subscription_referrer');
            $table->dropColumn('subscription_plan');
            $table->dropColumn('subscription_id');
            $table->dropColumn('subscription_active');
            $table->dropColumn('subscription_change_date');
            $table->string('promodcode', 50);
            $table->unsignedTinyInteger('revenue_share')->default(20);
            $table->string('paypal_email')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('credits')->after('balance');
            $table->dropColumn('promodcode');
            $table->dropColumn('revenue_share');
            $table->dropColumn('paypal_email');
        });
    }
}
