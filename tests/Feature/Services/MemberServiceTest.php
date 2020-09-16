<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace Tests\Feature\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Unit\Repositories\MemberRepositoryTest;
use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Tests\TestCase;

/**
 * @author:
 * Date: 12:59:29
 * Time: 2020/09/16
 * Class MemberServiceResponseList
 * @package Tests\Feature\Services
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
            $this->memberService = app()->make(MemberService::class);
            $this->memberRepositoryTest = app()->make(MemberRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberService, 'get']);
        self::assertTrue($result->status);
    }

    public function testStore(int $number = 0)
    {
        $memberServiceRequest = $this->getDummy($number);
        $result = app()->call([$this->memberService, 'store'], ['memberServiceRequest' => $memberServiceRequest['members']]);
        self::assertTrue($result->status);
        $memberServiceRequest['members'] = $result;
        return $memberServiceRequest;
    }

    private function getDummy(int $number = 0): array
    {
        $dummyData = app()->call([$this->memberRepositoryTest, 'getDummy'], ['no' => $number]);
        $memberServiceRequest = null;
        try {
            $memberServiceRequest = app()->make(MemberServiceRequest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
        $memberServiceRequest = Lazy::copy($dummyData['members'], $memberServiceRequest, Lazy::AUTOCAST);

        $dummyData['members'] = $memberServiceRequest;

        return $dummyData;
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $result = app()->call([$this->memberService, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $memberServiceResponse = $this->testStore();
        $memberServiceRequest = $this->getDummy();
        $result = app()->call([$this->memberService, 'update'], ['code' => $memberServiceResponse['members']->member->code, 'memberServiceRequest' => $memberServiceRequest['members']]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $memberServiceResponse = $this->testStore();
        $result = app()->call([$this->memberService, 'delete'], ['code' => $memberServiceResponse['members']->member->code]);
        self::assertTrue($result->status);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberService, 'get'], ['q' => $q]);
        self::assertTrue($result->status);
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = app()->call([$this->memberService, 'getCount'], ['q' => $q]);
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

        $result = app()->call([$this->memberService, 'getByCode'], ['code' => $result['members']->member->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByCodeList'], ['code' => $result['members']->member->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByEmail'], ['email' => $result['members']->member->email]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByEmailList'], ['email' => $result['members']->member->email]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getById'], ['id' => $result['members']->member->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByIdList'], ['id' => $result['members']->member->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentCode'], ['code' => $result['contents']->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentCodeList'], ['code' => $result['contents']->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentKeyword'], ['keyword' => $result['contents']->keyword]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentKeywordList'], ['keyword' => $result['contents']->keyword]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentOgDescription'], ['ogDescription' => $result['contents']->og_description]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentOgDescriptionList'], ['ogDescription' => $result['contents']->og_description]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentOgTitle'], ['ogTitle' => $result['contents']->og_title]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentOgTitleList'], ['ogTitle' => $result['contents']->og_title]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentTitle'], ['title' => $result['contents']->title]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentTitleList'], ['title' => $result['contents']->title]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentId'], ['id' => $result['contents']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByContentIdList'], ['id' => $result['contents']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByUserId'], ['id' => $result['users']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByUserIdList'], ['id' => $result['users']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByUserEmail'], ['email' => $result['users']->email]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByUserEmailList'], ['email' => $result['users']->email]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByIdentityTypeName'], ['name' => $result['identity_types']->name]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByIdentityTypeNameList'], ['name' => $result['identity_types']->name]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByIdentityTypeId'], ['id' => $result['identity_types']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByIdentityTypeIdList'], ['id' => $result['identity_types']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByLanguageCode'], ['code' => $result['languages']->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByLanguageCodeList'], ['code' => $result['languages']->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByLanguageId'], ['id' => $result['languages']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByLanguageIdList'], ['id' => $result['languages']->id]);
        self::assertTrue($result->status);
    }

    public function testGetByTimeZoneId()
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

        $result = app()->call([$this->memberService, 'getByTimeZoneId'], ['id' => $result['time_zones']->id]);
        self::assertTrue($result->status);
    }

    public function testGetByTimeZoneIdList()
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

        $result = app()->call([$this->memberService, 'getByTimeZoneIdList'], ['id' => $result['time_zones']->id]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByTimeZoneCode'], ['code' => $result['time_zones']->code]);
        self::assertTrue($result->status);
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

        $result = app()->call([$this->memberService, 'getByTimeZoneCodeList'], ['code' => $result['time_zones']->code]);
    }

}
