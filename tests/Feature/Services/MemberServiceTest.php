<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Content\Tests\Unit\Repositories\CategoryRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\ContentRepositoryTest;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\MemberAddressRepositoryTest;
use WebAppId\Member\Tests\Unit\Repositories\MemberRepositoryTest;

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

    /**
     * @var MemberAddressRepository
     */
    protected $memberAddressRepository;

    /**
     * @var MemberAddressRepositoryTest
     */
    protected $memberAddressRepositoryTest;

    /**
     * @var ContentRepositoryTest
     */
    protected $contentRepositoryTest;

    protected $categoryRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberService = app()->make(MemberService::class);
            $this->memberRepositoryTest = app()->make(MemberRepositoryTest::class);
            $this->memberAddressRepositoryTest = app()->make(MemberAddressRepositoryTest::class);
            $this->memberAddressRepository = app()->make(MemberAddressRepository::class);
            $this->contentRepositoryTest = app()->make(ContentRepositoryTest::class);
            $this->categoryRepositoryTest = app()->make(CategoryRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetByCode()
    {
        $memberServiceResponse = $this->testStore();
        $result = app()->call([$this->memberService, 'getByCode'], ['code' => $memberServiceResponse->member->code, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetById()
    {
        $memberServiceResponse = $this->testStore();
        $result = app()->call([$this->memberService, 'getById'], ['id' => $memberServiceResponse->member->id, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    private function getDummy(int $number = 0): MemberServiceRequest
    {
        $memberRepositoryRequest = app()->call([$this->memberRepositoryTest, 'getDummy'], ['no' => $number]);
        $memberServiceRequest = null;
        try {
            $memberServiceRequest = app()->make(MemberServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($memberRepositoryRequest, $memberServiceRequest);
    }

    private function getDummyContent(): ContentServiceRequest
    {
        $contentRepositoryRequest = app()->call([$this->contentRepositoryTest, 'getDummy']);
        $contentServiceRequest = null;
        try {
            $contentServiceRequest = app()->make(ContentServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($contentRepositoryRequest, $contentServiceRequest);
    }

    public function testStore(int $number = 0)
    {
        $memberServiceRequest = $this->getDummy($number);

        $contentServiceRequest = $this->getDummyContent();

        $category = app()->call([$this->categoryRepositoryTest, 'testStore']);

        $contentServiceRequest->categories = [$category->id];

        $result = app()->call([$this->memberService, 'store'], compact('memberServiceRequest', 'contentServiceRequest'));

        $memberAddressRepositoryRequest = app()->call([$this->memberAddressRepositoryTest, 'getDummy']);

        $memberAddressRepositoryRequest->member_id = $result->member->id;

        app()->call([$this->memberAddressRepository, 'store'], compact('memberAddressRepositoryRequest'));

        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $result = app()->call([$this->memberService, 'get'], ['ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $result = app()->call([$this->memberService, 'getCount'], ['ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $memberServiceResponse = $this->testStore();
        $memberServiceRequest = $this->getDummy();
        $contentServiceRequest = $this->getDummyContent();
        $contentServiceRequest->code = $memberServiceResponse->member->content;
        $result = app()->call([$this->memberService, 'update'], ['code' => $memberServiceResponse->member->code, 'memberServiceRequest' => $memberServiceRequest, 'contentServiceRequest' => $contentServiceRequest, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $memberServiceResponse = $this->testStore();
        $result = app()->call([$this->memberService, 'delete'], ['code' => $memberServiceResponse->member->code, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberService, 'get'], ['q' => $q, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberService, 'getCount'], ['q' => $q, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
