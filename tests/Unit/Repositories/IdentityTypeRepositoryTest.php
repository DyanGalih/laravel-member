<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Tests\Unit\Repositories;

use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Repositories\IdentityTypeRepository;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use WebAppId\Member\Tests\TestCase;
use WebAppId\User\Tests\Unit\Repositories\UserRepositoryTest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeServiceResponseList
 * @package Tests\Unit\Repositories
 */
class IdentityTypeRepositoryTest extends TestCase
{

    /**
     * @var IdentityTypeRepository
     */
    private $identityTypeRepository;

    /**
     * @var UserRepositoryTest
     */
    private $userRepositoryTest;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        try {
            $this->identityTypeRepository = $this->container->make(IdentityTypeRepository::class);
            $this->userRepositoryTest = $this->container->make(UserRepositoryTest::class);
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    public function getDummy(int $no = 0): ?IdentityTypeRepositoryRequest
    {
        $dummy = null;
        try {
            $dummy = $this->container->make(IdentityTypeRepositoryRequest::class);
            $user = $this->container->call([$this->userRepositoryTest, 'testStore']);
            $dummy->name = $this->getFaker()->text(50);
            $dummy->user_id = $user->id;

        } catch (BindingResolutionException $e) {
            report($e);
        }
        return $dummy;
    }

    public function testStore(int $no = 0): ?IdentityType
    {
        $identityTypeRepositoryRequest = $this->getDummy($no);
        $result = $this->container->call([$this->identityTypeRepository, 'store'], ['identityTypeRepositoryRequest' => $identityTypeRepositoryRequest]);

        self::assertNotEquals(null, $result);
        return $result;
    }

    public function testGetById()
    {
        $identityType = $this->testStore();
        $result = $this->container->call([$this->identityTypeRepository, 'getById'], ['id' => $identityType->id]);
        self::assertNotEquals(null, $result);
    }

    public function testGetByName()
    {
        $identityType = $this->testStore();
        $result = $this->container->call([$this->identityTypeRepository, 'getByName'], ['name' => $identityType->name]);
        self::assertNotEquals(null, $result);
    }

    public function testDelete()
    {
        $identityType = $this->testStore();
        $result = $this->container->call([$this->identityTypeRepository, 'delete'], ['id' => $identityType->id]);
        self::assertTrue($result);
    }

    public function testGet()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $resultList = $this->container->call([$this->identityTypeRepository, 'get']);
        self::assertGreaterThanOrEqual(1, count($resultList));
    }

    public function testGetCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }

        $result = $this->container->call([$this->identityTypeRepository, 'getCount']);
        self::assertGreaterThanOrEqual(1, $result);
    }

    public function testUpdate()
    {
        $identityType = $this->testStore();
        $identityTypeRepositoryRequest = $this->getDummy(1);
        $result = $this->container->call([$this->identityTypeRepository, 'update'], ['id' => $identityType->id, 'identityTypeRepositoryRequest' => $identityTypeRepositoryRequest]);
        self::assertNotEquals(null, $result);
    }

    public function testGetWhere()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->identityTypeRepository, 'get'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, count($result));
    }

    public function testGetWhereCount()
    {
        for ($i = 0; $i < $this->getFaker()->numberBetween(10, $this->getFaker()->numberBetween(10, 30)); $i++) {
            $this->testStore($i);
        }
        $string = 'aiueo';
        $q = $string[$this->getFaker()->numberBetween(0, strlen($string) - 1)];
        $result = $this->container->call([$this->identityTypeRepository, 'getCount'], ['q' => $q]);
        self::assertGreaterThanOrEqual(1, $result);
    }
}
