<?php

namespace Kregel\Flight;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spork\Core\Spork;

class FlightServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-flight');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-flight');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-flight.php'),
            ], 'config');
        }
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-flight');

        foreach (config('laravel-flight.community_drivers') as $driverListener) {
            Event::listen(\SocialiteProviders\Manager\SocialiteWasCalled::class, $driverListener);
        }
    }
}
