<?php

namespace WebAppId\Member\Tests;

use Illuminate\Container\Container;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use TestCaseTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->container = new Container();
        parent::__construct($name, $data, $dataName);
    }
}
