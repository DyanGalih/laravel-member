<?php
/**
 * Created by PhpStorm.
 * UserParam: dyangalih
 * Date: 2019-01-25
 * Time: 11:53
 */

namespace WebAppId\Member;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use WebAppId\Member\Commands\SeedCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->commands(SeedCommand::class);
    }

    public function boot()
    {
        if ($this->isLaravel53AndUp()) {
            $this->loadMigrationsFrom(__DIR__ . '/../src/migrations');
        } else {
            $this->publishes([
                __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
            ], 'migrations');
        }

        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    protected function isLaravel53AndUp()
    {
        return version_compare($this->app->version(), '5.3.0', '>=');
    }
}