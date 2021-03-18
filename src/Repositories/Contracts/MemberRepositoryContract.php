<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;

/**
 * @author: 
 * Date: 04:35:07
 * Time: 2021/03/14
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
    public function getByCode(string $code, Member $member):? Member;

    /**
     * @param string $code
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $creatorId
     * @param int $typeId
     * @param Member $member
     * @return Member
     */
    public function getByCreatorIdTypeId(int $creatorId, int $typeId, Member $member):? Member;

    /**
     * @param int $creatorId
     * @param int $typeId
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByCreatorIdTypeIdList(int $creatorId, int $typeId, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByEmail(string $email, Member $member):? Member;

    /**
     * @param string $email
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $name
     * @param Member $member
     * @return Member
     */
    public function getByName(string $name, Member $member):? Member;

    /**
     * @param string $name
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $name
     * @param int $typeId
     * @param Member $member
     * @return Member
     */
    public function getByNameTypeId(string $name, int $typeId, Member $member):? Member;

    /**
     * @param string $name
     * @param int $typeId
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByNameTypeIdList(string $name, int $typeId, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $ownerId
     * @param int $typeId
     * @param Member $member
     * @return Member
     */
    public function getByOwnerIdTypeId(int $ownerId, int $typeId, Member $member):? Member;

    /**
     * @param int $ownerId
     * @param int $typeId
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByOwnerIdTypeIdList(int $ownerId, int $typeId, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $phone
     * @param Member $member
     * @return Member
     */
    public function getByPhone(string $phone, Member $member):? Member;

    /**
     * @param string $phone
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByPhoneList(string $phone, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $sex
     * @param Member $member
     * @return Member
     */
    public function getBySex(string $sex, Member $member):? Member;

    /**
     * @param string $sex
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getBySexList(string $sex, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getById(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByContentCode(string $code, Member $member):? Member;

    /**
     * @param string $code
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $keyword
     * @param Member $member
     * @return Member
     */
    public function getByContentKeyword(string $keyword, Member $member):? Member;

    /**
     * @param string $keyword
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentKeywordList(string $keyword, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $ogDescription
     * @param Member $member
     * @return Member
     */
    public function getByContentOgDescription(string $ogDescription, Member $member):? Member;

    /**
     * @param string $ogDescription
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentOgDescriptionList(string $ogDescription, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $ogTitle
     * @param Member $member
     * @return Member
     */
    public function getByContentOgTitle(string $ogTitle, Member $member):? Member;

    /**
     * @param string $ogTitle
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentOgTitleList(string $ogTitle, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $title
     * @param Member $member
     * @return Member
     */
    public function getByContentTitle(string $title, Member $member):? Member;

    /**
     * @param string $title
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentTitleList(string $title, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByContentId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByContentIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $apiToken
     * @param Member $member
     * @return Member
     */
    public function getByUserApiToken(string $apiToken, Member $member):? Member;

    /**
     * @param string $apiToken
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByUserEmail(string $email, Member $member):? Member;

    /**
     * @param string $email
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByUserId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $name
     * @param Member $member
     * @return Member
     */
    public function getByIdentityTypeName(string $name, Member $member):? Member;

    /**
     * @param string $name
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdentityTypeNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByIdentityTypeId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByIdentityTypeIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByLanguageCode(string $code, Member $member):? Member;

    /**
     * @param string $code
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByLanguageCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByLanguageId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByLanguageIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $apiToken
     * @param Member $member
     * @return Member
     */
    public function getByOwnerUserApiToken(string $apiToken, Member $member):? Member;

    /**
     * @param string $apiToken
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByOwnerUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByOwnerUserEmail(string $email, Member $member):? Member;

    /**
     * @param string $email
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByOwnerUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByOwnerUserId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByOwnerUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $apiToken
     * @param Member $member
     * @return Member
     */
    public function getByProfileUserApiToken(string $apiToken, Member $member):? Member;

    /**
     * @param string $apiToken
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByProfileUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByProfileUserEmail(string $email, Member $member):? Member;

    /**
     * @param string $email
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByProfileUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByProfileUserId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByProfileUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $code
     * @param Member $member
     * @return Member
     */
    public function getByTimeZoneCode(string $code, Member $member):? Member;

    /**
     * @param string $code
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByTimeZoneCodeList(string $code, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByTimeZoneId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByTimeZoneIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $name
     * @param Member $member
     * @return Member
     */
    public function getByMemberTypeName(string $name, Member $member):? Member;

    /**
     * @param string $name
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByMemberTypeNameList(string $name, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByMemberTypeId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByMemberTypeIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $apiToken
     * @param Member $member
     * @return Member
     */
    public function getByUserUserApiToken(string $apiToken, Member $member):? Member;

    /**
     * @param string $apiToken
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserUserApiTokenList(string $apiToken, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param string $email
     * @param Member $member
     * @return Member
     */
    public function getByUserUserEmail(string $email, Member $member):? Member;

    /**
     * @param string $email
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserUserEmailList(string $email, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

    /**
     * @param int $id
     * @param Member $member
     * @return Member
     */
    public function getByUserUserId(int $id, Member $member):? Member;

    /**
     * @param int $id
     * @param Member $member
     * @param string|null $q
     * @param int $length
     * @return LengthAwarePaginator
     */
    public function getByUserUserIdList(int $id, Member $member, string $q = null, int $length = 12): LengthAwarePaginator;

}
