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
     * @param string $code
     * @param MemberRepositoryRequest $dummyRepositoryClassRequest
     * @param Member $member
     * @param int|null $ownerId
     * @return Member|null
     */
    public function update(string $code,
                           MemberRepositoryRequest $dummyRepositoryClassRequest,
                           Member $member,
                           int $ownerId = null): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int|null $ownerId
     * @return Member|null
     */
    public function getByCode(string $code,
                              Member $member,
                              int $ownerId = null): ?Member;

    /**
     * @param int $id
     * @param Member $member
     * @param int|null $ownerId
     * @return Member|null
     */
    public function getById(int $id, Member $member,
                            int $ownerId = null): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int|null $ownerId
     * @return bool
     */
    public function delete(string $code,
                           Member $member,
                           int $ownerId = null): bool;

    /**
     * @param Member $member
     * @param int $length
     * @param string|null $q
     * @param int|null $ownerId
     * @return LengthAwarePaginator
     */
    public function get(Member $member,
                        int $length = 12,
                        string $q = null,
                        int $ownerId = null): LengthAwarePaginator;

    /**
     * @param Member $member
     * @param string|null $q
     * @param int|null $ownerId
     * @return int
     */
    public function getCount(Member $member,
                             string $q = null,
                             int $ownerId = null): int;

    /**
     * @param Member $member
     * @param string $identity
     * @param string $memberId
     * @return bool
     */
    public function checkAvailableIdentity(Member $member,
                                           string $identity,
                                           string $memberId): bool;

    /**
     * @param Member $member
     * @param string $email
     * @param string $memberId
     * @return bool
     */
    public function checkAvailableEmail(Member $member, string $email, string $memberId): bool;
}
