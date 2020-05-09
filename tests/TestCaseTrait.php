<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Tests;


use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;
use WebAppId\Member\ServiceProvider;
use WebAppId\User\Models\User;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 09/05/2020
 * Time: 09.56
 * Class TestCaseTrait
 * @package WebAppId\Member\Tests
 */
trait TestCaseTrait
{
    private $faker;

    protected $container;

    /**
     * Set up the test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom([
            '--realpath' => realpath(__DIR__ . './src/migrations'),
        ]);
        $this->artisan('webappid:member:seed');

    }

    protected function getFaker()
    {
        if ($this->faker == null) {
            $this->faker = new Faker;
        }

        return $this->faker->create('id_ID');
    }

    protected function getPackageProviders($app)
    {
        return [
            \WebAppId\User\ServiceProvider::class,
            \WebAppId\Content\ServiceProvider::class,
            ServiceProvider::class
        ];
    }

    public function tearDown():void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }

    protected function secure()
    {
        $user = new User;
        $user = $user->find('1');
        if ($user != null) {
            $this->be($user);
        } else {
            dd('please add user with id 1 to run this unit test');
        }
        return $user;
    }

    protected function sendToLog(string $serviceName, string $endpoint, array $data)
    {
        error_log('==========================================================');
        error_log('Service Name : ' . $serviceName);
        error_log('Endpoint : ' . $endpoint);
        error_log('Payload : ' . json_encode($data));
    }

    protected function resultLog(string $result){
        error_log('==========================================================');
        error_log('Sample Result : ' . $result);
        error_log('==========================================================');
    }
}