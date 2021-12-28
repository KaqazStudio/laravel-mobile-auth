<?php


namespace KaqazStudio\LaravelMobileAuth\ServiceProvider;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelMobileAuthRouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                 ->namespace($this->namespace)
                 ->group(__DIR__. '/../routes/web.php');
        });
    }
}
