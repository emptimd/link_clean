<?php

namespace App\Providers;

use App\Classes\Fastspring;
use Illuminate\Support\ServiceProvider;

class FastSpringServiceProvider extends ServiceProvider
{

//    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Fastspring::class, function() {
            return new Fastspring(config('app.fastspring.company'), config('app.fastspring.store'), config('app.fastspring.user'), config('app.fastspring.password'));
        });
    }
}
