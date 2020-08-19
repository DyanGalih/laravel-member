<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use WebAppId\Member\Models\MemberType;
use WebAppId\Member\Repositories\MemberTypeRepository;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeServiceResponseList
 * @package WebAppId\Member\Tests\Unit\Repositories
 */
class MemberTypeRepositoryTest extends TestCase
{

    /**
     * @var MemberTypeRepository
     */
    private $memberTypeRepository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberTypeRepository = app()->make(MemberTypeRepository::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getDummy(int $no = 0): ?MemberTypeRepositoryRequest
    {
        $dummy = null;
        try {
            $dummy = app()->make(MemberTypeRepositoryRequest::class);
            $dummy->name = $this->getFaker()->text(50);

        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $dummy;
    }

    public function testStore(int $no = 0): ?MemberType
    {
        $memberTypeRepositoryRequest = $this->getDummy($no);
        $result = app()->call([$this->memberTypeRepository, 'store'], ['memberTypeRepositoryRequest' => $memberTypeRepositoryRequest]);
        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetById()
    {
        $memberType = $this->testStore();
        $result = app()->call([$this->memberTypeRepository, 'getById'], ['id' => $memberType->id]);
        self::assertNotEquals(null, $result);
    }

    public function testGetByName()
    {
        $memberType = $this->testStore();
        $result = app()->call([$this->memberTypeRepository, 'getByName'], ['name' => $memberType->name]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $memberType = $this->testStore();
        $result = app()->call([$this->memberTypeRepository, 'delete'], ['id' => $memberType->id]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $resultList = app()->call([$this->memberTypeRepository, 'get']);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $result = app()->call([$this->memberTypeRepository, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $memberType = $this->testStore();
        $memberTypeRepositoryRequest = $this->getDummy(1);
        $result = app()->call([$this->memberTypeRepository, 'update'], ['id' => $memberType->id, 'memberTypeRepositoryRequest' => $memberTypeRepositoryRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberTypeRepository, 'get'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberTypeRepository, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
