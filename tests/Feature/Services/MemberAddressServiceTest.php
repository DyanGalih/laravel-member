<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Services\MemberAddressService;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\MemberAddressRepositoryTest;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressServiceResponseList
 * @package WebAppId\Member\Tests\Feature\Services
 */
class MemberAddressServiceTest extends TestCase
{

    /**
     * @var MemberAddressService
     */
    protected $memberAddressService;

    /**
     * @var MemberAddressRepositoryTest
     */
    protected $memberAddressRepositoryTest;

    /**
     * @var MemberRepository
     */
    protected $memberRepository;

    /**
     * @var Member
     */
    protected $member;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberAddressService = app()->make(MemberAddressService::class);
            $this->memberRepository = app()->make(MemberRepository::class);
            $this->memberAddressRepositoryTest = app()->make(MemberAddressRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetByCode()
    {
        $contentServiceResponse = $this->testStore();
        $member = app()->call([$this->memberRepository, 'getById'], ['id' => $contentServiceResponse->memberAddress->member_id]);
        $result = app()->call([$this->memberAddressService, 'getByCode'], ['memberCode' => $member->code, 'code' => $contentServiceResponse->memberAddress->code]);
        self::assertTrue($result->status);
    }

    private function getDummy(int $number = 0): MemberAddressServiceRequest
    {
        $memberAddressRepositoryRequest = app()->call([$this->memberAddressRepositoryTest, 'getDummy'], ['no' => $number]);
        if ($this->member == null) {
            $this->member = app()->call([$this->memberAddressRepositoryTest, 'getMember']);
        }
        $memberAddressServiceRequest = null;
        try {
            $memberAddressServiceRequest = app()->make(MemberAddressServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($memberAddressRepositoryRequest, $memberAddressServiceRequest);
    }

    public function testStore(int $number = 0)
    {
        $memberAddressServiceRequest = $this->getDummy($number);
        $result = app()->call([$this->memberAddressService, 'store'], ['code' => $this->member->code, 'memberAddressServiceRequest' => $memberAddressServiceRequest]);
        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberAddressService, 'get'], ['identity' => $this->member->identity]);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberAddressService, 'getCount'], ['identity' => $this->member->identity]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $contentServiceResponse = $this->testStore();
        $memberAddressServiceRequest = $this->getDummy();
        $member = app()->call([$this->memberRepository, 'getById'], ['id' => $contentServiceResponse->memberAddress->member_id]);
        $result = app()->call([$this->memberAddressService, 'update'], ['identity' => $member->identity, 'code' => $contentServiceResponse->memberAddress->code, 'memberAddressServiceRequest' => $memberAddressServiceRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $contentServiceResponse = $this->testStore();
        $result = app()->call([$this->memberAddressService, 'delete'], ['memberCode' => $this->member->code, 'code' => $contentServiceResponse->memberAddress->code]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberAddressService, 'get'], ['identity' => $this->member->identity, 'q' => $q]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberAddressService, 'getCount'], ['identity' => $this->member->identity, 'q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
