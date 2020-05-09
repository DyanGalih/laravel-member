<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface MemberRepositoryContract
{
    /**
     * @param MemberRepositoryRequest $dummyRepositoryClassRequest
     * @param Member $member
     * @return Member|null
     */
    public function store(MemberRepositoryRequest $dummyRepositoryClassRequest, Member $member): ?Member;

    /**
     * @param int $id
     * @param MemberRepositoryRequest $dummyRepositoryClassRequest
     * @param Member $member
     * @return Member|null
     */
    public function update(int $id, MemberRepositoryRequest $dummyRepositoryClassRequest, Member $member): ?Member;

    /**
     * @param int $id
     * @param Member $member
     * @return Member|null
     */
    public function getById(int $id, Member $member): ?Member;

    /**
     * @param int $id
     * @param Member $member
     * @return bool
     */
    public function delete(int $id, Member $member): bool;

    /**
     * @param Member $member
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(Member $member, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param Member $member
     * @return int
     * @param string $q
     */
    public function getCount(Member $member, string $q = null): int;

}