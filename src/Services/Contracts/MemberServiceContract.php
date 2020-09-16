<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use WebAppId\Member\Services\Responses\MemberServiceResponseList;


/**
 * @author:
 * Date: 12:59:29
 * Time: 2020/09/16
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
    public function get(MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12, string $q = null): MemberServiceResponseList;

    /**
     * @param string|null $q
     * @param MemberRepository $memberRepository
     * @return int
     */
    public function getCount(MemberRepository $memberRepository, string $q = null): int;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentKeywordList(string $keyword, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentOgDescriptionList(string $ogDescription, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentOgTitleList(string $ogTitle, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentTitleList(string $title, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByContentIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByIdentityTypeNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByIdentityTypeIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByLanguageCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByLanguageIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByTimeZoneIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

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
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function getByTimeZoneCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12): MemberServiceResponseList;

}
