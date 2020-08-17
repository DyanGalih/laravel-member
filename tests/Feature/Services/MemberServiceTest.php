<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Feature\Services;

use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Content\Tests\Unit\Repositories\CategoryRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\ContentRepositoryTest;
use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\MemberAddressRepositoryTest;
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
            $this->memberService = $this->container->make(MemberService::class);
            $this->memberRepositoryTest = $this->container->make(MemberRepositoryTest::class);
            $this->memberAddressRepositoryTest = $this->container->make(MemberAddressRepositoryTest::class);
            $this->memberAddressRepository = $this->container->make(MemberAddressRepository::class);
            $this->contentRepositoryTest = $this->container->make(ContentRepositoryTest::class);
            $this->categoryRepositoryTest = $this->container->make(CategoryRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGetByCode()
    {
        $memberServiceResponse = $this->testStore();
        $result = $this->container->call([$this->memberService, 'getByCode'], ['code' => $memberServiceResponse->member->code, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetById()
    {
        $memberServiceResponse = $this->testStore();
        $result = $this->container->call([$this->memberService, 'getById'], ['id' => $memberServiceResponse->member->id, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
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

    private function getDummyContent(): ContentServiceRequest
    {
        $contentRepositoryRequest = $this->container->call([$this->contentRepositoryTest, 'getDummy']);
        $contentServiceRequest = null;
        try {
            $contentServiceRequest = $this->container->make(ContentServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return Lazy::copy($contentRepositoryRequest, $contentServiceRequest);
    }

    public function testStore(int $number = 0)
    {
        $memberServiceRequest = $this->getDummy($number);

        $contentServiceRequest = $this->getDummyContent();

        $category = $this->container->call([$this->categoryRepositoryTest, 'testStore']);

        $contentServiceRequest->categories = [$category->id];

        $result = $this->container->call([$this->memberService, 'store'], compact('memberServiceRequest', 'contentServiceRequest'));

        $memberAddressRepositoryRequest = $this->container->call([$this->memberAddressRepositoryTest, 'getDummy']);

        $memberAddressRepositoryRequest->member_id = $result->member->id;

        $this->container->call([$this->memberAddressRepository, 'store'], compact('memberAddressRepositoryRequest'));

        self::assertTrue($result->status);
        return $result;
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $result = $this->container->call([$this->memberService, 'get'],['ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $result = $this->container->call([$this->memberService, 'getCount'], ['ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $memberServiceResponse = $this->testStore();
        $memberServiceRequest = $this->getDummy();
        $contentServiceRequest = $this->getDummyContent();
        $contentServiceRequest->code = $memberServiceResponse->member->content;
        $result = $this->container->call([$this->memberService, 'update'], ['code' => $memberServiceResponse->member->code, 'memberServiceRequest' => $memberServiceRequest, 'contentServiceRequest' => $contentServiceRequest, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $memberServiceResponse = $this->testStore();
        $result = $this->container->call([$this->memberService, 'delete'], ['id' => $memberServiceResponse->member->id,'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberService, 'get'], ['q' => $q, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $memberServiceResponse = $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberService, 'getCount'], ['q' => $q, 'ownerId' => $this->getFaker()->boolean ? $memberServiceResponse->member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
