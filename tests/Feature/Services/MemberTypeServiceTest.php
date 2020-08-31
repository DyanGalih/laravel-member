<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Services\MemberTypeService;
use WebAppId\Member\Services\Requests\MemberTypeServiceRequest;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\MemberTypeRepositoryTest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeServiceResponseList
 * @package WebAppId\Member\Tests\Feature\Services
 */
class MemberTypeServiceTest extends TestCase
{

    /**
     * @var MemberTypeService
     */
    protected $memberTypeService;

    /**
     * @var MemberTypeRepositoryTest
     */
    protected $memberTypeRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberTypeService = app()->make(MemberTypeService::class);
            $this->memberTypeRepositoryTest = app()->make(MemberTypeRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetById()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->memberTypeService, 'getById'], ['id' => $contentServiceResponse->memberType->id]);
        self::assertTrue($result->status);
    }

    private function getDummy(int $number = 0): MemberTypeServiceRequest
    {
        $memberTypeRepositoryRequest = app()->call([$this->memberTypeRepositoryTest, 'getDummy'], ['no' => $number]);
        $memberTypeServiceRequest = null;
        try {
            $memberTypeServiceRequest = app()->make(MemberTypeServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($memberTypeRepositoryRequest, $memberTypeServiceRequest, Lazy::AUTOCAST);
    }

    public function testStore(int $number = 0)
    {
        $memberTypeServiceRequest = $this->getDummy($number);
        $result = app()->call([$this->memberTypeService, 'store'], ['memberTypeServiceRequest' => $memberTypeServiceRequest]);
        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberTypeService, 'get']);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberTypeService, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $contentServiceResponse = $this->testStore();
        $memberTypeServiceRequest = $this->getDummy();
        $result = app()->call([$this->memberTypeService, 'update'], ['id' => $contentServiceResponse->memberType->id, 'memberTypeServiceRequest' => $memberTypeServiceRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->memberTypeService, 'delete'], ['id' => $contentServiceResponse->memberType->id]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberTypeService, 'get'], ['q' => $q]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberTypeService, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
