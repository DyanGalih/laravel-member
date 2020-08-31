<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Member\Models\MemberAddress;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;

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
     * @param string $code
     * @param MemberAddressRepositoryRequest $dummyRepositoryClassRequest
     * @param MemberAddress $memberAddress
     * @return MemberAddress|null
     */
    public function update(string $code, MemberAddressRepositoryRequest $dummyRepositoryClassRequest, MemberAddress $memberAddress): ?MemberAddress;

    /**
     * @param string $code
     * @param MemberAddress $memberAddress
     * @return MemberAddress|null
     */
    public function getByCode(string $code, MemberAddress $memberAddress): ?MemberAddress;

    /**
     * @param string $code
     * @param MemberAddress $memberAddress
     * @return bool
     */
    public function delete(string $code, MemberAddress $memberAddress): bool;

    /**
     * @param string $identity
     * @param MemberAddress $memberAddress
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(string $identity, MemberAddress $memberAddress, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param string $identity
     * @param MemberAddress $memberAddress
     * @param string $q
     * @return int
     */
    public function getCount(string $identity, MemberAddress $memberAddress, string $q = null): int;

}
