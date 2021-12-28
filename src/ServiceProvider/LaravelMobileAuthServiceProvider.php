<?php


namespace KaqazStudio\LaravelMobileAuth\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use KaqazStudio\LaravelMobileAuth\LaravelMobileAuth;

class LaravelMobileAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LaravelMobileAuth', function() {
            return new LaravelMobileAuth();
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->_loadRoutes();
        $this->_loadViews();
        $this->_loadStyles();
        $this->_loadMigrations();
    }

    private function _loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    private function _loadViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'LaravelMobileAuth');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/LaravelMobileAuth')
        ],'laravel-mobile-auth-views');
    }

    private function _loadStyles(): void
    {
        $this->publishes([
            __DIR__.'/../resources/css' => resource_path('css/vendor/LaravelMobileAuth')
        ], 'laravel-mobile-auth-styles');
    }

    private function _loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations')
        ], 'laravel-mobile-auth-migrations');
    }

}
