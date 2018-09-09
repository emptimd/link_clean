<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CampaignBacklinksAnalyzerCmd::class,
        \App\Console\Commands\CampaignBacklinksGetCmd::class,
        \App\Console\Commands\CampaignBacklinksProcessCmd::class,
        \App\Console\Commands\CampaignBacklinksProcessEndCmd::class,
        \App\Console\Commands\CampaignGoogleMalwareCmd::class,
        \App\Console\Commands\DomainSocialCmd::class,
        \App\Console\Commands\CampaignEngagedCountCmd::class,
        \App\Console\Commands\CampaignTopicsCmd::class,
        \App\Console\Commands\Approve::class, // check if fastspring rebill event is approved
        \App\Console\Commands\Clean::class, // clean
        \App\Console\Commands\GoogleAnalitycsCmd::class,
        \App\Console\Commands\AutoCredits::class,
        \App\Console\Commands\Monitoring::class,
        \App\Console\Commands\NotificationsCmd::class,
        \App\Console\Commands\AutoSubscribe::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('dispatcher')->everyMinute();

        $schedule->command('cleaner')->twiceDaily();

        $schedule->command('approve')->daily();
        $schedule->command('auto_credits')->daily();
        $schedule->command('monitoring')->daily();
        $schedule->command('subscription:auto')->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
