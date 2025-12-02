<?php

namespace Vigilant\StatamicHealthchecks\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Vigilant\LaravelHealthchecks\ServiceProvider as LaravelHealthchecksServiceProvider;
use Vigilant\StatamicHealthchecks\ServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            LaravelHealthchecksServiceProvider::class,
        ];
    }
}
