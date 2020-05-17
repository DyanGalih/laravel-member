<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use WebAppId\Content\Tests\Unit\Repositories\ContentRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\FileRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\LanguageRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\TimeZoneRepositoryTest;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\User\Tests\Unit\Repositories\UserRepositoryTest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceResponseList
 * @package WebAppId\Member\Tests\Unit\Repositories
 */
class MemberRepositoryTest extends TestCase
{

    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * @var IdentityTypeRepositoryTest
     */
    private $identityRepositoryTest;

    /**
     * @var TimeZoneRepositoryTest
     */
    private $timezoneRepositoryTest;

    /**
     * @var LanguageRepositoryTest
     */
    private $languageRepositoryTest;

    /**
     * @var ContentRepositoryTest
     */
    private $contentRepositoryTest;

    /**
     * @var UserRepositoryTest
     */
    private $userRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberRepository = $this->container->make(MemberRepository::class);
            $this->identityRepositoryTest = $this->container->make(IdentityTypeRepositoryTest::class);
            $this->timezoneRepositoryTest = $this->container->make(TimeZoneRepositoryTest::class);
            $this->languageRepositoryTest = $this->container->make(LanguageRepositoryTest::class);
            $this->contentRepositoryTest = $this->container->make(ContentRepositoryTest::class);
            $this->userRepositoryTest = $this->container->make(UserRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getDummy(int $no = 0): ?MemberRepositoryRequest
    {
        $dummy = null;
        try {
            $sexList = ['M', 'F', 'O'];
            $sex = $sexList[$this->getFaker()->numberBetween(0, count($sexList) - 1)];
            $dummy = $this->container->make(MemberRepositoryRequest::class);
            $identityType = $this->container->call([$this->identityRepositoryTest, 'testStore']);
            $timeZone = $this->container->call([$this->timezoneRepositoryTest, 'testStore']);
            $language = $this->container->call([$this->languageRepositoryTest, 'testStore']);
            $content = $this->container->call([$this->contentRepositoryTest, 'testStore']);
            $user = $this->container->call([$this->userRepositoryTest, 'testStore']);
            $dummy->identity_type_id = $identityType->id;
            $dummy->identity = $this->getFaker()->text(255);
            $dummy->name = $this->getFaker()->name;
            $dummy->email = $this->getFaker()->text(100);
            $dummy->phone = $this->getFaker()->text(20);
            $dummy->phone_alternative = $this->getFaker()->text(255);
            $dummy->sex = $sex;
            $dummy->dob = $this->getFaker()->dateTime();
            $dummy->timezone_id = $timeZone->id;
            $dummy->language_id = $language->id;
            $dummy->content_id = $content->id;
            $dummy->user_id = $user->id;
            $dummy->creator_id = $user->id;
            $dummy->owner_id = $user->id;

        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $dummy;
    }

    public function testStore(int $no = 0): ?Member
    {
        $memberRepositoryRequest = $this->getDummy($no);
        $result = $this->container->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetByIdentity()
    {
        $member = $this->testStore();
        $result = $this->container->call([$this->memberRepository, 'getByIdentity'], ['identity' => $member->identity]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $member = $this->testStore();
        $result = $this->container->call([$this->memberRepository, 'delete'], ['identity' => $member->identity]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $resultList = $this->container->call([$this->memberRepository, 'get']);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $result = $this->container->call([$this->memberRepository, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $member = $this->testStore();
        $memberRepositoryRequest = $this->getDummy(1);
        $result = $this->container->call([$this->memberRepository, 'update'], ['identity' => $member->identity, 'memberRepositoryRequest' => $memberRepositoryRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberRepository, 'get'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberRepository, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
