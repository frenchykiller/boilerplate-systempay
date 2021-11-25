<?php

namespace Frenchykiller\LaravelSystempay;

use Frenchykiller\LaravelSystempay\View\Components\Systempay;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SystempayServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        //Publishes package config file to applications config folder
        $this->publishes([__DIR__ . '/config/systempay.php' => config_path('systempay.php')], ['systempay-config']);

        // Load views from current directory
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-systempay');

        Blade::component('systempay', Systempay::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Only load library if it is called
     *
     * @return array
     */
    public function provides()
    {
    }
}
