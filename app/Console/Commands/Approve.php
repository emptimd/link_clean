<?php

namespace App\Console\Commands;

use App\Models\RefEvents;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Approve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approves rebills events';

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
        \Log::info('im insde approve');
        if(!RefEvents::has('referral')
            ->where('revenue_status', 'Hold')
            ->where('created_at', '<', Carbon::now()->subMonth()->toDateTimeString())
            ->count()) dd('Nothing found to process.');

        /** @var RefEvents $events */
        $events = RefEvents::has('referral')
            ->with(['referral'])
            ->where('revenue_status', 'Hold')
            ->where('created_at', '<', Carbon::now()->subMonth()->toDateTimeString())
            ->get();

        // move money from referrals balance_hold to balance_approved
        foreach($events as $event) {
            $event->referral->balance_hold -= $event->revenue;
            $event->referral->balance_approved += $event->revenue;
            $event->referral->save();

            // add money to referrers balance
            User::find($event->referral->referrer_id)->increment('balance', $event->revenue);

            // change status to approved
            $event->update(['revenue_status' => 'Approved']);
        }

    }
}
