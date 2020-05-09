<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use WebAppId\Member\Models\MemberAddress;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface MemberAddressRepositoryContract
{
    /**
     * @param MemberAddressRepositoryRequest $dummyRepositoryClassRequest
     * @param MemberAddress $memberAddress
     * @return MemberAddress|null
     */
    public function store(MemberAddressRepositoryRequest $dummyRepositoryClassRequest, MemberAddress $memberAddress): ?MemberAddress;

    /**
     * @param int $id
     * @param MemberAddressRepositoryRequest $dummyRepositoryClassRequest
     * @param MemberAddress $memberAddress
     * @return MemberAddress|null
     */
    public function update(int $id, MemberAddressRepositoryRequest $dummyRepositoryClassRequest, MemberAddress $memberAddress): ?MemberAddress;

    /**
     * @param int $id
     * @param MemberAddress $memberAddress
     * @return MemberAddress|null
     */
    public function getById(int $id, MemberAddress $memberAddress): ?MemberAddress;

    /**
     * @param int $id
     * @param MemberAddress $memberAddress
     * @return bool
     */
    public function delete(int $id, MemberAddress $memberAddress): bool;

    /**
     * @param MemberAddress $memberAddress
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(MemberAddress $memberAddress, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param MemberAddress $memberAddress
     * @return int
     * @param string $q
     */
    public function getCount(MemberAddress $memberAddress, string $q = null): int;

}
