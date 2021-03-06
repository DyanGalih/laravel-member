<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Member\Models\MemberType;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface MemberTypeRepositoryContract
{
    /**
     * @param MemberTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param MemberType $memberType
     * @return MemberType|null
     */
    public function store(MemberTypeRepositoryRequest $dummyRepositoryClassRequest, MemberType $memberType): ?MemberType;

    /**
     * @param int $id
     * @param MemberTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param MemberType $memberType
     * @return MemberType|null
     */
    public function update(int $id, MemberTypeRepositoryRequest $dummyRepositoryClassRequest, MemberType $memberType): ?MemberType;

    /**
     * @param int $id
     * @param MemberType $memberType
     * @return MemberType|null
     */
    public function getById(int $id, MemberType $memberType): ?MemberType;

    /**
     * @param int $id
     * @param MemberType $memberType
     * @return bool
     */
    public function delete(int $id, MemberType $memberType): bool;

    /**
     * @param MemberType $memberType
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(MemberType $memberType, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param MemberType $memberType
     * @param string $q
     * @return int
     */
    public function getCount(MemberType $memberType, string $q = null): int;

    /**
     * @param string $name
     * @param MemberType $memberType
     * @return MemberType|null
     */
    public function getByName(string $name, MemberType $memberType): ?MemberType;

}
