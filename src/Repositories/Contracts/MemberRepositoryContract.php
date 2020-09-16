<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @author:
 * Date: 12:59:28
 * Time: 2020/09/16
 * Class MemberRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface MemberRepositoryContract
{
    /**
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param Member $member
     * @return Member|null
     */
    public function store(MemberRepositoryRequest $memberRepositoryRequest, Member $member): ?Member;

    /**
     * @param string $code
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param Member $member
     * @return Member|null
     */
    public function update(string $code, MemberRepositoryRequest $memberRepositoryRequest, Member $member): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @return bool
     */
    public function delete(string $code, Member $member): bool;

    /**
     * @param Member $member
     * @param int $length
     * @param string|null $q
     * @return LengthAwarePaginator
     */
    public function get(Member $member, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param Member $member
     * @param string|null $q
     * @return int
     */
    public function getCount(Member $member, string $q = null): int;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByCode(string $code, Member $member): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByCodeList(string $code, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $contentId
     * @param Member $member
     * @return Member
     */
    public function getByContentId(int $contentId, Member $member): ?Member;

    /**
     * @param int $contentId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentIdList(int $contentId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $creatorId
     * @param Member $member
     * @return Member
     */
    public function getByCreatorId(int $creatorId, Member $member): ?Member;

    /**
     * @param int $creatorId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByCreatorIdList(int $creatorId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByEmail(string $email, Member $member): ?Member;

    /**
     * @param string $email
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByEmailList(string $email, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $identityTypeId
     * @param Member $member
     * @return Member
     */
    public function getByIdentityTypeId(int $identityTypeId, Member $member): ?Member;

    /**
     * @param int $identityTypeId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdentityTypeIdList(int $identityTypeId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $languageId
     * @param Member $member
     * @return Member
     */
    public function getByLanguageId(int $languageId, Member $member): ?Member;

    /**
     * @param int $languageId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByLanguageIdList(int $languageId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $ownerId
     * @param Member $member
     * @return Member
     */
    public function getByOwnerId(int $ownerId, Member $member): ?Member;

    /**
     * @param int $ownerId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByOwnerIdList(int $ownerId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $profileId
     * @param Member $member
     * @return Member
     */
    public function getByProfileId(int $profileId, Member $member): ?Member;

    /**
     * @param int $profileId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByProfileIdList(int $profileId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $timezoneId
     * @param Member $member
     * @return Member
     */
    public function getByTimezoneId(int $timezoneId, Member $member): ?Member;

    /**
     * @param int $timezoneId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByTimezoneIdList(int $timezoneId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $userId
     * @param Member $member
     * @return Member
     */
    public function getByUserId(int $userId, Member $member): ?Member;

    /**
     * @param int $userId
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserIdList(int $userId, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getById(int $id, Member $member): ?Member;

    /**
     * @param int $id
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdList(int $id, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByContentCode(string $code, Member $member): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentCodeList(string $code, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $keyword
     * @param Member $member
     * @return Member
     */
    public function getByContentKeyword(string $keyword, Member $member): ?Member;

    /**
     * @param string $keyword
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentKeywordList(string $keyword, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $ogDescription
     * @param Member $member
     * @return Member
     */
    public function getByContentOgDescription(string $ogDescription, Member $member): ?Member;

    /**
     * @param string $ogDescription
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentOgDescriptionList(string $ogDescription, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $ogTitle
     * @param Member $member
     * @return Member
     */
    public function getByContentOgTitle(string $ogTitle, Member $member): ?Member;

    /**
     * @param string $ogTitle
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentOgTitleList(string $ogTitle, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $title
     * @param Member $member
     * @return Member
     */
    public function getByContentTitle(string $title, Member $member): ?Member;

    /**
     * @param string $title
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentTitleList(string $title, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByUserEmail(string $email, Member $member): ?Member;

    /**
     * @param string $email
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserEmailList(string $email, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $name
     * @param Member $member
     * @return Member
     */
    public function getByIdentityTypeName(string $name, Member $member): ?Member;

    /**
     * @param string $name
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdentityTypeNameList(string $name, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByLanguageCode(string $code, Member $member): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByLanguageCodeList(string $code, Member $member, int $length = 12): ?LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByTimeZoneCode(string $code, Member $member): ?Member;

    /**
     * @param string $code
     * @param Member $member
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByTimeZoneCodeList(string $code, Member $member, int $length = 12): ?LengthAwarePaginator;

}
