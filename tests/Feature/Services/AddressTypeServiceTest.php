<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Services\AddressTypeService;
use WebAppId\Member\Services\Requests\AddressTypeServiceRequest;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\AddressTypeRepositoryTest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeServiceResponseList
 * @package WebAppId\Member\Tests\Feature\Services
 */
class AddressTypeServiceTest extends TestCase
{

    /**
     * @var AddressTypeService
     */
    protected $addressTypeService;

    /**
     * @var AddressTypeRepositoryTest
     */
    protected $addressTypeRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->addressTypeService = app()->make(AddressTypeService::class);
            $this->addressTypeRepositoryTest = app()->make(AddressTypeRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetById()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->addressTypeService, 'getById'], ['id' => $contentServiceResponse->addressType->id]);
        self::assertTrue($result->status);
    }

    public function testGetByName()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->addressTypeService, 'getByName'], ['name' => $contentServiceResponse->addressType->name]);
        self::assertTrue($result->status);
    }

    private function getDummy(int $number = 0): AddressTypeServiceRequest
    {
        $addressTypeRepositoryRequest = app()->call([$this->addressTypeRepositoryTest, 'getDummy'], ['no' => $number]);
        $addressTypeServiceRequest = null;
        try {
            $addressTypeServiceRequest = app()->make(AddressTypeServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($addressTypeRepositoryRequest, $addressTypeServiceRequest, Lazy::AUTOCAST);
    }

    public function testStore(int $number = 0)
    {
        $addressTypeServiceRequest = $this->getDummy($number);
        $result = app()->call([$this->addressTypeService, 'store'], ['addressTypeServiceRequest' => $addressTypeServiceRequest]);
        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->addressTypeService, 'get']);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->addressTypeService, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $contentServiceResponse = $this->testStore();
        $addressTypeServiceRequest = $this->getDummy();
        $result = app()->call([$this->addressTypeService, 'update'], ['id' => $contentServiceResponse->addressType->id, 'addressTypeServiceRequest' => $addressTypeServiceRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->addressTypeService, 'delete'], ['id' => $contentServiceResponse->addressType->id]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->addressTypeService, 'get'], ['q' => $q]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->addressTypeService, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
