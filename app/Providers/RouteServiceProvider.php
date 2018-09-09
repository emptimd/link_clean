<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        Route::namespace($this->namespace)->group(function () {

            Route::prefix('admin')
                ->middleware('web')
                ->namespace('Back')
                ->group(function () {
                    require base_path('routes/back.php');
                });

            Route::middleware('web')
                ->group(function () {
                        Auth::routes();
                        Route::namespace('Front')->group(function () {
                            require base_path('routes/front.php');
                        });
                });
        });
    }

}
