<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface IdentityTypeRepositoryContract
{
    /**
     * @param IdentityTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param IdentityType $identityType
     * @return IdentityType|null
     */
    public function store(IdentityTypeRepositoryRequest $dummyRepositoryClassRequest, IdentityType $identityType): ?IdentityType;

    /**
     * @param int $id
     * @param IdentityTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param IdentityType $identityType
     * @return IdentityType|null
     */
    public function update(int $id, IdentityTypeRepositoryRequest $dummyRepositoryClassRequest, IdentityType $identityType): ?IdentityType;

    /**
     * @param int $id
     * @param IdentityType $identityType
     * @return IdentityType|null
     */
    public function getById(int $id, IdentityType $identityType): ?IdentityType;

    /**
     * @param string $name
     * @param IdentityType $identityType
     * @return IdentityType|null
     */
    public function getByName(string $name, IdentityType $identityType): ?IdentityType;

    /**
     * @param int $id
     * @param IdentityType $identityType
     * @return bool
     */
    public function delete(int $id, IdentityType $identityType): bool;

    /**
     * @param IdentityType $identityType
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(IdentityType $identityType, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param IdentityType $identityType
     * @return int
     * @param string $q
     */
    public function getCount(IdentityType $identityType, string $q = null): int;

}
