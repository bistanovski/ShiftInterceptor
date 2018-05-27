<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapIndexRoutes();
        $this->mapWebApiRoutes();
        $this->mapClientApiRoutes();
    }

    /**
     * Define the "index" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapIndexRoutes()
    {
        Route::middleware('index')
             ->namespace($this->namespace)
             ->group(base_path('routes/index.php'));
    }

    /**
     * Define the "web-api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebApiRoutes()
    {
        Route::prefix('api')
             ->middleware('web-api')
             ->namespace($this->namespace)
             ->group(base_path('routes/web-api.php'));
    }

    /**
     * Define the "client-api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapClientApiRoutes()
    {
        Route::prefix('api')
             ->middleware('client-api')
             ->namespace($this->namespace)
             ->group(base_path('routes/client-api.php'));
    }
}
