<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->mapAPiRoutes();
        $this->mapFrontRoutes();
        $this->mapBackendRoutes();
    }

    protected function mapAPiRoutes()
    {
        Route::prefix('api')
            //->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(base_path('routes/api-routes.php'));
    }

    protected function mapFrontRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Frontend')
            ->group(base_path('routes/frontend-routes.php'));
    }

    protected function mapBackendRoutes()
    {
        // maybe a extra middleware is needed to check the users role/permission etc.
        Route::middleware('web')
            ->namespace($this->namespace . 'Backend')
            ->group(base_path('routes/backend-routes.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('Api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
