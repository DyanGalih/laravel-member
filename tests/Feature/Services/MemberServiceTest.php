<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\MemberRepositoryTest;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceResponseList
 * @package WebAppId\Member\Tests\Feature\Services
 */
class MemberServiceTest extends TestCase
{

    /**
     * @var MemberService
     */
    protected $memberService;

    /**
     * @var MemberRepositoryTest
     */
    protected $memberRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberService = $this->container->make(MemberService::class);
            $this->memberRepositoryTest = $this->container->make(MemberRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetById()
    {
        $contentServiceResponse = $this->testStore();
        $result = $this->container->call([$this->memberService, 'getById'], ['id' => $contentServiceResponse->member->id]);
        self::assertTrue($result->status);
    }

    private function getDummy(int $number = 0): MemberServiceRequest
    {
        $memberRepositoryRequest = $this->container->call([$this->memberRepositoryTest, 'getDummy'], ['no' => $number]);
        $memberServiceRequest = null;
        try {
            $memberServiceRequest = $this->container->make(MemberServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($memberRepositoryRequest, $memberServiceRequest);
    }

    public function testStore(int $number = 0)
    {
        $memberServiceRequest = $this->getDummy($number);
        $result = $this->container->call([$this->memberService, 'store'], ['memberServiceRequest' => $memberServiceRequest]);
        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i=0; $i<$this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++){
            $this->testStore($i);
        }
        $result = $this->container->call([$this->memberService, 'get']);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i=0; $i<$this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++){
            $this->testStore($i);
        }
        $result = $this->container->call([$this->memberService, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $contentServiceResponse = $this->testStore();
        $memberServiceRequest = $this->getDummy();
        $result = $this->container->call([$this->memberService, 'update'], ['id' => $contentServiceResponse->member->id, 'memberServiceRequest' => $memberServiceRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $contentServiceResponse = $this->testStore();
        $result = $this->container->call([$this->memberService, 'delete'], ['id' => $contentServiceResponse->member->id]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberService, 'get'], ['q' => $q]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberService, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
