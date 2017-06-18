<?php

namespace sinkcup\LaravelLocaleSetterTests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $locale_map;

    public function setUp()
    {
        $this->locale_map = require(__DIR__ . '/../config/locale.php');
    }

    public function createApplication()
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->register('sinkcup\LaravelLocaleSetter\LocaleServiceProvider');

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}
