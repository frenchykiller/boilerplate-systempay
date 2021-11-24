<?php

namespace Frenchykiller\BoilerplateSystempay;

use Frenchykiller\BoilerplateSystempay\View\Composers\SystempayComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        $this->publishes([__DIR__ . '/config/boilerplate/systempay.php' => config_path('systempay.php')],['systempay-config','boilerplate-config']);

        // Load views from current directory
        $this->loadViewsFrom(__DIR__.'/resources/views', 'boilerplate-systempay');

        // Load view composers
        View::composer('boilerplate-systempay::components.systempay', SystempayComposer::class);

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
     * @return array
     */
    public function provides()
    {

    }

}
