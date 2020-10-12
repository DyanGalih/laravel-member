<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use DyanGalih\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use WebAppId\Member\Services\Responses\MemberServiceResponseList;

/**
 * @author: 
 * Date: 18:40:56
 * Time: 2020/10/08
 * Class MemberServiceContract
 * @package WebAppId\Member\Services\Contracts
 */
interface MemberServiceContract
{
    /**
     * @param MemberServiceRequest $memberServiceRequest
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function store(MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberServiceRequest $memberServiceRequest
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function update(string $code, MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse $memberServiceResponse
     */
    public function delete(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string|null $q
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function get(MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList,int $length = 12, string $q = null): MemberServiceResponseList;

    /**
     * @param string|null $q
     * @param MemberRepository $memberRepository
     * @return int
     */
    public function getCount(MemberRepository $memberRepository, string $q = null):int;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $creatorId
     * @param int $typeId
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByCreatorIdTypeId(int $creatorId, int $typeId, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $creatorId
     * @param int $typeId
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByCreatorIdTypeIdList(int $creatorId, int $typeId, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $ownerId
     * @param int $typeId
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByOwnerIdTypeId(int $ownerId, int $typeId, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $ownerId
     * @param int $typeId
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByOwnerIdTypeIdList(int $ownerId, int $typeId, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $phone
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByPhone(string $phone, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $phone
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByPhoneList(string $phone, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $sex
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getBySex(string $sex, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $sex
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getBySexList(string $sex, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getById(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $keyword
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentKeyword(string $keyword, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $keyword
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentKeywordList(string $keyword, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $ogDescription
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentOgDescription(string $ogDescription, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $ogDescription
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentOgDescriptionList(string $ogDescription, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $ogTitle
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentOgTitle(string $ogTitle, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $ogTitle
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentOgTitleList(string $ogTitle, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $title
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentTitle(string $title, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $title
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentTitleList(string $title, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByContentId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByContentIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByIdentityTypeName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByIdentityTypeNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByIdentityTypeId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByIdentityTypeIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByLanguageCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByLanguageCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByLanguageId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByLanguageIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByOwnerUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByOwnerUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByOwnerUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByOwnerUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByOwnerUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByOwnerUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByProfileUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByProfileUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByProfileUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByProfileUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByProfileUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByProfileUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByTimeZoneCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByTimeZoneCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByTimeZoneId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByTimeZoneIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByMemberTypeName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $name
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByMemberTypeNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByMemberTypeId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByMemberTypeIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $apiToken
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $email
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByUserUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param string|null $q
     * @param int $length
     * @return MemberServiceResponseList
     */
   public function getByUserUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null, int $length = 12): MemberServiceResponseList;

}
