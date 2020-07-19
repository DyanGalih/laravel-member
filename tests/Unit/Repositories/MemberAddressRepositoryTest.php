<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use WebAppId\Member\Models\Member;
use WebAppId\Member\Models\MemberAddress;
use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\User\Tests\Unit\Repositories\UserRepositoryTest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressServiceResponseList
 * @package WebAppId\Member\Tests\Unit\Repositories
 */
class MemberAddressRepositoryTest extends TestCase
{

    /**
     * @var MemberAddressRepository
     */
    private $memberAddressRepository;

    /**
     * @var MemberRepositoryTest
     */
    private $memberRepositoryTest;

    /**
     * @var UserRepositoryTest
     */
    private $userRepositoryTest;

    /**
     * @var AddressTypeRepositoryTest
     */
    private $addressTypeRepositoryTest;

    /**
     * @var Member
     */
    private $member;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->memberAddressRepository = $this->container->make(MemberAddressRepository::class);
            $this->memberRepositoryTest = $this->container->make(MemberRepositoryTest::class);
            $this->userRepositoryTest = $this->container->make(UserRepositoryTest::class);
            $this->addressTypeRepositoryTest = $this->container->make(AddressTypeRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getDummy(int $no = 0): ?MemberAddressRepositoryRequest
    {
        $dummy = null;
        try {
            $dummy = $this->container->make(MemberAddressRepositoryRequest::class);
            $user = $this->container->call([$this->userRepositoryTest, 'testStore']);

            if ($this->member == null) {
                $this->member = $this->container->call([$this->memberRepositoryTest, 'testStore']);
            }

            $addressType = $this->container->call([$this->addressTypeRepositoryTest, 'testStore']);
            $dummy->type_id = $addressType->id;
            $dummy->code = $this->getFaker()->uuid;
            $dummy->name = $this->getFaker()->domainName;
            $dummy->member_id = $this->member->id;
            $dummy->address = $this->getFaker()->text(65535);
            $dummy->city = $this->getFaker()->text(255);
            $dummy->state = $this->getFaker()->text(255);
            $dummy->post_code = $this->getFaker()->text(255);
            $dummy->country = $this->getFaker()->text(255);
            $dummy->isDefault = $this->getFaker()->boolean ? "true" : "false";
            $dummy->user_id = $user->id;
            $dummy->creator_id = $user->id;
            $dummy->owner_id = $user->id;

        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $dummy;
    }

    public function testStore(int $no = 0): ?MemberAddress
    {
        $memberAddressRepositoryRequest = $this->getDummy($no);
        $result = $this->container->call([$this->memberAddressRepository, 'store'], ['memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetByCode()
    {
        $memberAddress = $this->testStore();
        $result = $this->container->call([$this->memberAddressRepository, 'getByCode'], ['code' => $memberAddress->code]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $memberAddress = $this->testStore();
        $result = $this->container->call([$this->memberAddressRepository, 'delete'], ['code' => $memberAddress->code]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }

        $resultList = $this->container->call([$this->memberAddressRepository, 'get'], ['identity' => $this->member->identity]);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }

        $result = $this->container->call([$this->memberAddressRepository, 'getCount'], ['identity' => $this->member->identity]);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $memberAddress = $this->testStore();
        $memberAddressRepositoryRequest = $this->getDummy(1);
        $result = $this->container->call([$this->memberAddressRepository, 'update'], ['code' => $memberAddress->code, 'memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberAddressRepository, 'get'], ['identity' => $this->member->identity, 'q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(5, $this->getFaker()->numberBetween(5, 10)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->memberAddressRepository, 'getCount'], ['identity' => $this->member->identity, 'q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
