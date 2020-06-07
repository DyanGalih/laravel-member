<?php

namespace WebAppId\Member\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use WebAppId\DDD\Traits\TestCaseTrait;
use WebAppId\Member\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use TestCaseTrait;

    /**
     * Set up the test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--realpath' => realpath(__DIR__ . './src/migrations'),
        ]);
        $this->artisan('webappid:user:seed');
        $this->artisan('webappid:member:seed');

    }

    protected function getPackageProviders($app)
    {
        return [
            \WebAppId\User\ServiceProvider::class,
            \WebAppId\Content\ServiceProvider::class,
            ServiceProvider::class
        ];
    }
}
