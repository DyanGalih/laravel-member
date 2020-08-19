<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use WebAppId\Member\Models\AddressType;
use WebAppId\Member\Repositories\AddressTypeRepository;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeServiceResponseList
 * @package WebAppId\Member\Tests\Unit\Repositories
 */
class AddressTypeRepositoryTest extends TestCase
{

    /**
     * @var AddressTypeRepository
     */
    private $addressTypeRepository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->addressTypeRepository = app()->make(AddressTypeRepository::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getDummy(int $no = 0): ?AddressTypeRepositoryRequest
    {
        $dummy = null;
        try {
            $dummy = app()->make(AddressTypeRepositoryRequest::class);
            $dummy->name = $this->getFaker()->text(50);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $dummy;
    }

    public function testStore(int $no = 0): ?AddressType
    {
        $addressTypeRepositoryRequest = $this->getDummy($no);
        $result = app()->call([$this->addressTypeRepository, 'store'], ['addressTypeRepositoryRequest' => $addressTypeRepositoryRequest]);
        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetById()
    {
        $addressType = $this->testStore();
        $result = app()->call([$this->addressTypeRepository, 'getById'], ['id' => $addressType->id]);
        self::assertNotEquals(null, $result);
    }

    public function testGetByName()
    {
        $addressType = $this->testStore();
        $result = app()->call([$this->addressTypeRepository, 'getByName'], ['name' => $addressType->name]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $addressType = $this->testStore();
        $result = app()->call([$this->addressTypeRepository, 'delete'], ['id' => $addressType->id]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $resultList = app()->call([$this->addressTypeRepository, 'get']);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $result = app()->call([$this->addressTypeRepository, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $addressType = $this->testStore();
        $addressTypeRepositoryRequest = $this->getDummy(1);
        $result = app()->call([$this->addressTypeRepository, 'update'], ['id' => $addressType->id, 'addressTypeRepositoryRequest' => $addressTypeRepositoryRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->addressTypeRepository, 'get'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->addressTypeRepository, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
