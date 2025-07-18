<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Home path for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        $this->routes(function () {
            // API routes load karne ka code
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // Web routes load karne ka code
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
