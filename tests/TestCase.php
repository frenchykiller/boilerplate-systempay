<?php

namespace Frenchykiller\LaravelSystempay\Tests;

use Frenchykiller\LaravelSystempay\SystempayServiceProvider;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use InteractsWithViews;

    /**
     * Load package service provider.
     *
     * @param   \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SystempayServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('systempay.default', [
            'site_id'   => '73239078',
            'key'       => 'testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ',
        ]);
    }
}
