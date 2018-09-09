<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('layouts.main', function ($view) {
            $crock = \App\Models\Crock::where('user_id', auth()->id())->get(['url', 'created_at']);
            $open_tickets = \App\Models\Ticket::where('status', 'open')->count();
            $notifications = \App\Models\Notification::where('user_id', auth()->id())->count();

            $view->with(['crock' => $crock, 'open_tickets' => $open_tickets, 'notifications' => $notifications]);
        });

        View::composer('partials._ajax_campaigns_buttons', function ($view) {
            $progress = (new \App\Models\Campaign(['stage'=>10, 'stage_status'=>0]))->progress();

            $view->with(['progress' => $progress]);
        });
    }
}
