<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Tests;

use Illuminate\Container\Container;
use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 09/05/2020
 * Time: 09.52
 * Class WebTestCase
 * @package WebAppId\Member\Tests
 */
abstract class WebTestCase extends BaseTestCase
{
    use TestCaseTrait;
    public $baseUrl = 'http://127.0.0.1';


    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->container = new Container();
        parent::__construct($name, $data, $dataName);
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'WebAppId\Member\Http\Kernel');
    }
}