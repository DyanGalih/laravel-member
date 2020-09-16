<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace Tests\Unit\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Content\Tests\Unit\Repositories\ContentRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\LanguageRepositoryTest;
use WebAppId\Content\Tests\Unit\Repositories\TimeZoneRepositoryTest;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Tests\TestCase;
use WebAppId\Member\Tests\Unit\Repositories\IdentityTypeRepositoryTest;
use WebAppId\User\Tests\Unit\Repositories\UserRepositoryTest;


/**
 * @author:
 * Date: 12:59:29
 * Time: 2020/09/16
 * Class MemberServiceResponseList
 * @package Tests\Unit\Repositories
 */
class MemberRepositoryTest extends TestCase
{

    /**
     * @var MemberRepository
     */
    private $memberRepository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberRepository = app()->make(MemberRepository::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getDummy(int $no = 0): ?array
    {
        $result = [];
        try {
            $userRepositoryTest = app()->make(UserRepositoryTest::class);
            $user = app()->call([$userRepositoryTest, 'testStore']);
            $result['users'] = $user;
            $identityTypeRepositoryTest = app()->make(IdentityTypeRepositoryTest::class);
            $identityType = app()->call([$identityTypeRepositoryTest, 'testStore']);
            $result['identity_types'] = $identityType;
            $timeZoneRepositoryTest = app()->make(TimeZoneRepositoryTest::class);
            $timeZone = app()->call([$timeZoneRepositoryTest, 'testStore']);
            $result['time_zones'] = $timeZone;
            $languageRepositoryTest = app()->make(LanguageRepositoryTest::class);
            $language = app()->call([$languageRepositoryTest, 'testStore']);
            $result['languages'] = $language;
            $contentRepositoryTest = app()->make(ContentRepositoryTest::class);
            $content = app()->call([$contentRepositoryTest, 'testStore']);
            $result['contents'] = $content;
            $member = app()->make(MemberRepositoryRequest::class);
            $member->profile_id = $user->id;
            $member->code = $this->getFaker()->text(100);
            $member->identity_type_id = $identityType->id;
            $member->identity = $this->getFaker()->text(255);
            $member->name = $this->getFaker()->text(255);
            $member->email = $this->getFaker()->text(100);
            $member->phone = $this->getFaker()->text(20);
            $member->phone_alternative = $this->getFaker()->text(255);
            $sexes = explode(",", "M,F,O");
            $member->sex = $sexes[$this->getFaker()->numberBetween(0, count($sexes) - 1)];
            $member->dob = $this->getFaker()->date("Y-m-d H:m:i");
            $member->timezone_id = $timeZone->id;
            $member->language_id = $language->id;
            $member->content_id = $content->id;
            $member->user_id = $user->id;
            $member->creator_id = $user->id;
            $member->owner_id = $user->id;

            $result['members'] = $member;
        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $result;
    }

    public function testStore(int $no = 0): ?array
    {
        $memberRepositoryRequest = $this->getDummy($no);
        $result = app()->call([$this->memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest['members']]);
        self::assertNotEquals(null, $result);
        $memberRepositoryRequest['members'] = $result;
        return $memberRepositoryRequest;
    }

    public function testDelete()
    {
        $member = $this->testStore();
        $result = app()->call([$this->memberRepository, 'delete'], ['code' => $member['members']->code]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }

        $resultList = app()->call([$this->memberRepository, 'get']);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }

        $result = app()->call([$this->memberRepository, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $member = $this->testStore();
        $memberRepositoryRequest = $this->getDummy(1);
        $result = app()->call([$this->memberRepository, 'update'], ['code' => $member['members']->code, 'memberRepositoryRequest' => $memberRepositoryRequest['members']]);
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

    public function testGetByCode()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByCode'], ['code' => $result['members']->code]);
        self::assertNotNull($resultData);
    }

    public function testGetByCodeList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByCodeList'], ['code' => $result['members']->code]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentId'], ['contentId' => $result['members']->content_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentIdList'], ['contentId' => $result['members']->content_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByCreatorId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByCreatorId'], ['creatorId' => $result['members']->creator_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByCreatorIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByCreatorIdList'], ['creatorId' => $result['members']->creator_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByEmail()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByEmail'], ['email' => $result['members']->email]);
        self::assertNotNull($resultData);
    }

    public function testGetByEmailList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByEmailList'], ['email' => $result['members']->email]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByIdentityTypeId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByIdentityTypeId'], ['identityTypeId' => $result['members']->identity_type_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByIdentityTypeIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByIdentityTypeIdList'], ['identityTypeId' => $result['members']->identity_type_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByLanguageId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByLanguageId'], ['languageId' => $result['members']->language_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByLanguageIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByLanguageIdList'], ['languageId' => $result['members']->language_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByOwnerId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByOwnerId'], ['ownerId' => $result['members']->owner_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByOwnerIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByOwnerIdList'], ['ownerId' => $result['members']->owner_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByProfileId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByProfileId'], ['profileId' => $result['members']->profile_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByProfileIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByProfileIdList'], ['profileId' => $result['members']->profile_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByTimezoneId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByTimezoneId'], ['timezoneId' => $result['members']->timezone_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByTimezoneIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByTimezoneIdList'], ['timezoneId' => $result['members']->timezone_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByUserId()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByUserId'], ['userId' => $result['members']->user_id]);
        self::assertNotNull($resultData);
    }

    public function testGetByUserIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByUserIdList'], ['userId' => $result['members']->user_id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetById()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getById'], ['id' => $result['members']->id]);
        self::assertNotNull($resultData);
    }

    public function testGetByIdList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByIdList'], ['id' => $result['members']->id]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentCode()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentCode'], ['code' => $result['contents']->code]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentCodeList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentCodeList'], ['code' => $result['contents']->code]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentKeyword()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentKeyword'], ['keyword' => $result['contents']->keyword]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentKeywordList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentKeywordList'], ['keyword' => $result['contents']->keyword]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentOgDescription()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentOgDescription'], ['ogDescription' => $result['contents']->og_description]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentOgDescriptionList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentOgDescriptionList'], ['ogDescription' => $result['contents']->og_description]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentOgTitle()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentOgTitle'], ['ogTitle' => $result['contents']->og_title]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentOgTitleList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentOgTitleList'], ['ogTitle' => $result['contents']->og_title]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByContentTitle()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentTitle'], ['title' => $result['contents']->title]);
        self::assertNotNull($resultData);
    }

    public function testGetByContentTitleList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByContentTitleList'], ['title' => $result['contents']->title]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByUserEmail()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByUserEmail'], ['email' => $result['users']->email]);
        self::assertNotNull($resultData);
    }

    public function testGetByUserEmailList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByUserEmailList'], ['email' => $result['users']->email]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByIdentityTypeName()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByIdentityTypeName'], ['name' => $result['identity_types']->name]);
        self::assertNotNull($resultData);
    }

    public function testGetByIdentityTypeNameList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByIdentityTypeNameList'], ['name' => $result['identity_types']->name]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByLanguageCode()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByLanguageCode'], ['code' => $result['languages']->code]);
        self::assertNotNull($resultData);
    }

    public function testGetByLanguageCodeList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByLanguageCodeList'], ['code' => $result['languages']->code]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

    public function testGetByTimeZoneCode()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByTimeZoneCode'], ['code' => $result['time_zones']->code]);
        self::assertNotNull($resultData);
    }

    public function testGetByTimeZoneCodeList()
    {

        $max = $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10));

        $random = $this->getFaker()->numberBetween(0, $max - 1);

        $result = null;

        for ($i = 0; $i < $max; $i++) {
            if ($random == $i) {
                $result = $this->testStore($i);
            } else {
                $this->testStore($i);
            }
        }

        $resultData = app()->call([$this->memberRepository, 'getByTimeZoneCodeList'], ['code' => $result['time_zones']->code]);
        self::assertGreaterThanOrEqual(1, count($resultData));
    }

}
