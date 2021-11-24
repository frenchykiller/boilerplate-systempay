<?php

namespace Frenchykiller\BoilerplateSystempay;

use Illuminate\Support\ServiceProvider;

class SystempayServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        //Publishes package config file to applications config folder
        $this->publishes([__DIR__ . '/config/systempay.php' => config_path('systempay.php')],['systempay','systempay-config']);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('systempay', 'Frenchykiller\BoilerplateSystempay\Systempay');
    }

    /**
     * Only load library if it is called
     * @return array
     */
    public function provides()
    {
        return ['systempay'];
    }

}
