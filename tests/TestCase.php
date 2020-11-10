<?php

namespace Pipes\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Pipes\PipesServiceProvider;

class TestCase extends Orchestra
{
    /**
     * getPackageProviders
     *
     * Register package service provider
     *
     */
    protected function getPackageProviders($app)
    {
        return [
            PipesServiceProvider::class,
        ];
    }
}
