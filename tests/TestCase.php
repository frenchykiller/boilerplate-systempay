<?php

namespace Frenchykiller\LaravelSystempay\Tests;

use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Frenchykiller\LaravelSystempay\SystempayServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SystempayServiceProvider::class,
        ];
    }

    /**
     * Render the contents of the given Blade template string.
     *
     * @param  string  $template
     * @param  array  $data
     * @return string
     */
    protected function blade(string $template, array $data = [])
    {
        $this->withoutMix();
        $tempDirectory = sys_get_temp_dir();

        if (! in_array($tempDirectory, ViewFacade::getFinder()->getPaths())) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFileInfo = pathinfo(tempnam($tempDirectory, 'laravel-blade'));
        $tempFile = $tempFileInfo['dirname'].'/'.$tempFileInfo['filename'].'.blade.php';
        file_put_contents($tempFile, $template);

        ViewFacade::share('errors', (new ViewErrorBag)->put('default', new MessageBag([
            'fielderror' => ['Error message'],
        ])));

        return trim(view($tempFileInfo['filename'], $data)->render());
    }
}
