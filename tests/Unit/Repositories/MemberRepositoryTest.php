<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Content\Tests\Unit\Repositories\ContentRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\LanguageRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\TimeZoneRepositoryTest;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
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
        $this->memberRepository = app()->make(MemberRepository::class);
        $this->identityRepositoryTest = app()->make(IdentityTypeRepositoryTest::class);
        $this->timezoneRepositoryTest = app()->make(TimeZoneRepositoryTest::class);
        $this->languageRepositoryTest = app()->make(LanguageRepositoryTest::class);
        $this->contentRepositoryTest = app()->make(ContentRepositoryTest::class);
        $this->userRepositoryTest = app()->make(UserRepositoryTest::class);
    }

    public function getDummy(int $no = 0): ?MemberRepositoryRequest
    {
        $dummy = null;
        $sexList = ['M', 'F', 'O'];
        $sex = $sexList[$this->getFaker()->numberBetween(0, count($sexList) - 1)];
        try {
            $dummy = app()->make(MemberRepositoryRequest::class);
            $identityType = app()->call([$this->identityRepositoryTest, 'testStore']);
            $timeZone = app()->call([$this->timezoneRepositoryTest, 'testStore']);
            $language = app()->call([$this->languageRepositoryTest, 'testStore']);
            $content = app()->call([$this->contentRepositoryTest, 'testStore']);
            $user = app()->call([$this->userRepositoryTest, 'testStore']);
            $dummy->identity_type_id = $identityType->id;
            $dummy->identity = $this->getFaker()->uuid;
            $dummy->profile_id = $user->id;
            $dummy->name = $this->getFaker()->name;
            $dummy->email = $this->getFaker()->safeEmailDomain;
            $dummy->phone = $this->getFaker()->text(20);
            $dummy->phone_alternative = $this->getFaker()->text(20);
            $dummy->sex = $sex;
            $dummy->dob = $this->getFaker()->dateTime()->format('Y-m-d');
            $dummy->timezone_id = $timeZone->id;
            $dummy->language_id = $language->id;
            $dummy->content_id = $content->id;
            $dummy->user_id = $user->id;
            $dummy->creator_id = $user->id;
            $dummy->owner_id = $user->id;
            return $dummy;
        } catch (BindingResolutionException $e) {
            report($e);
            return null;
        }
    }

    public function testStore(int $no = 0): ?Member
    {
        $memberRepositoryRequest = $this->getDummy($no);
        $result = app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetByCode()
    {
        $member = $this->testStore();
        $result = app()->call([$this->memberRepository, 'getByCode'], ['code' => $member->code, 'ownerId' => $this->getFaker()->boolean ? $member->owner_id : null]);
        self::assertNotEquals(null, $result);
    }

    public function testGetById()
    {
        $member = $this->testStore();
        $result = app()->call([$this->memberRepository, 'getById'], ['id' => $member->id, 'ownerId' => $this->getFaker()->boolean ? $member->owner_id : null]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $member = $this->testStore();
        $result = app()->call([$this->memberRepository, 'delete'], ['code' => $member->code, 'ownerId' => $this->getFaker()->boolean ? $member->owner_id : null]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $member = $this->testStore($i);
        }

        $resultList = app()->call([$this->memberRepository, 'get'], ['ownerId' => $this->getFaker()->boolean ? $member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $member = $this->testStore($i);
        }

        $result = app()->call([$this->memberRepository, 'getCount'], ['ownerId' => $this->getFaker()->boolean ? $member->owner_id : null]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $member = $this->testStore();
        $memberRepositoryRequest = $this->getDummy(1);
        $ownerId = $this->getFaker()->boolean ? $member->owner_id : null;
        $result = app()->call([$this->memberRepository, 'update'],
            [
                'code' => $member->code,
                'memberRepositoryRequest' => $memberRepositoryRequest,
                'ownerId' => $this->getFaker()->boolean ? $member->owner_id : null
            ]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberRepository, 'get'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberRepository, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testAvailableIdentity()
    {
        $member = $this->testStore();
        $result = app()->call([$this->memberRepository, 'checkAvailableIdentity'], ['identity' => $member->identity]);
        self::assertEquals(null, $result);
    }

    public function testAvailableIdentityById()
    {
        $memberRepositoryRequest = $this->getDummy();
        $identity = $memberRepositoryRequest->identity;
        app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        $memberRepositoryRequest = $this->getDummy();
        $member = app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        $result = app()->call([$this->memberRepository, 'checkAvailableIdentity'], ['identity' => $identity, 'memberId' => $member->id]);
        self::assertTrue($result);
    }

    public function testAvailableEmail()
    {
        $memberRepositoryRequest = $this->getDummy();
        $email = $memberRepositoryRequest->email;
        app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        $memberRepositoryRequest = $this->getDummy();
        $member = app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        $result = app()->call([$this->memberRepository, 'checkAvailableEmail'], ['email' => $this->getFaker()->email, 'memberId' => $member->id]);
        self::assertTrue($result);
    }
}
