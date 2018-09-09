<?php

namespace App\Console\Commands;

use App\Models\AutoCredit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_credits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add credits to users';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('im insde autocredits');
        /** @var AutoCredit $events */
        $events = AutoCredit::where('date', Carbon::now()->toDateString());

        // move money from referrals balance_hold to balance_approved
        foreach($events->get() as $event) {
            // add backlinks to user
            User::find($event->user_id)->increment('backlinks', $event->backlinks);

//            $event->date = Carbon::now()->addMonth()->toDateString();
//            $event->save();
        }

        $events->update(['date' => Carbon::now()->addMonth()->toDateString()]);

    }
}
