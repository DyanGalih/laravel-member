<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use WebAppId\Member\Services\Responses\MemberServiceResponseList;

/**
 * @author: 
 * Date: 18:40:40
 * Time: 2020/10/08
 * Class MemberServiceTrait
 * @package WebAppId\Member\Services
 */
trait MemberServiceTrait
{

    /**
     * @inheritDoc
     */
    public function store(MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Store Data Success';
            $memberServiceResponse->member = $result;
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Store Data Failed';
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function update(string $code, MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$memberRepository, 'update'], ['code' => $code, 'memberRepositoryRequest' => $memberRepositoryRequest]);
        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Update Data Success';
            $memberServiceResponse->member = $result;
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Update Data Failed';
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $status = app()->call([$memberRepository, 'delete'], compact('code'));
        $memberServiceResponse->status = $status;
        if($status){
            $memberServiceResponse->message = "Delete Success";
        }else{
            $memberServiceResponse->message = "Delete Failed";
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function get(MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12, string $q = null): MemberServiceResponseList
    {
        $result = app()->call([$memberRepository, 'get'], compact('q', 'length'));
        if (count($result) > 0) {
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = 'Data Found';
            $memberServiceResponseList->memberList = $result;
            $memberServiceResponseList->count = $result->total();
            $memberServiceResponseList->countFiltered = $result->count();
        } else {
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = 'Data Not Found';
        }
        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getCount(MemberRepository $memberRepository, string $q = null): int
    {
        return app()->call([$memberRepository, 'getCount'], compact('q'));
    }
    /**
     * @inheritDoc
     */
    public function getByCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByCode'], compact('code'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByCodeList'], compact('code', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByCreatorIdTypeId(int $creatorId, int $typeId, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByCreatorIdTypeId'], compact('creatorId', 'typeId'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByCreatorIdTypeIdList(int $creatorId, int $typeId, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByCreatorIdTypeIdList'], compact('creatorId', 'typeId', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByEmail'], compact('email'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByEmailList'], compact('email', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByName'], compact('name'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByNameList'], compact('name', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerIdTypeId(int $ownerId, int $typeId, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByOwnerIdTypeId'], compact('ownerId', 'typeId'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerIdTypeIdList(int $ownerId, int $typeId, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByOwnerIdTypeIdList'], compact('ownerId', 'typeId', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByPhone(string $phone, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByPhone'], compact('phone'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByPhoneList(string $phone, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByPhoneList'], compact('phone', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getBySex(string $sex, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getBySex'], compact('sex'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getBySexList(string $sex, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getBySexList'], compact('sex', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getById'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentCode'], compact('code'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentCodeList'], compact('code', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentKeyword(string $keyword, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentKeyword'], compact('keyword'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentKeywordList(string $keyword, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentKeywordList'], compact('keyword', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescription(string $ogDescription, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentOgDescription'], compact('ogDescription'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgDescriptionList(string $ogDescription, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentOgDescriptionList'], compact('ogDescription', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitle(string $ogTitle, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentOgTitle'], compact('ogTitle'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentOgTitleList(string $ogTitle, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentOgTitleList'], compact('ogTitle', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentTitle(string $title, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentTitle'], compact('title'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentTitleList(string $title, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentTitleList'], compact('title', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByContentId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByContentId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByContentIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByContentIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserApiToken'], compact('apiToken'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserApiTokenList'], compact('apiToken', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserEmail'], compact('email'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserEmailList'], compact('email', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByIdentityTypeName'], compact('name'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByIdentityTypeNameList'], compact('name', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByIdentityTypeId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByIdentityTypeIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByIdentityTypeIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByLanguageCode'], compact('code'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByLanguageCodeList'], compact('code', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByLanguageId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByLanguageIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByLanguageIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserApiToken'], compact('apiToken'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserApiTokenList'], compact('apiToken', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserEmail'], compact('email'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserEmailList'], compact('email', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByOwnerUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByOwnerUserIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByProfileUserApiToken'], compact('apiToken'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByProfileUserApiTokenList'], compact('apiToken', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByProfileUserEmail'], compact('email'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByProfileUserEmailList'], compact('email', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByProfileUserId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByProfileUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByProfileUserIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCode(string $code, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByTimeZoneCode'], compact('code'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneCodeList(string $code, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByTimeZoneCodeList'], compact('code', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByTimeZoneId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByTimeZoneIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByTimeZoneIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeName(string $name, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByMemberTypeName'], compact('name'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeNameList(string $name, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByMemberTypeNameList'], compact('name', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByMemberTypeId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByMemberTypeIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByMemberTypeIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserApiToken(string $apiToken, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserUserApiToken'], compact('apiToken'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserApiTokenList(string $apiToken, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserUserApiTokenList'], compact('apiToken', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserEmail(string $email, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserUserEmail'], compact('email'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserEmailList(string $email, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserUserEmailList'], compact('email', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserId(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $member = app()->call([$memberRepository, 'getByUserUserId'], compact('id'));
        if($member == null){
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = "Data Not Found";
        }else{
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = "Data Found";
            $memberServiceResponse->member = $member;
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByUserUserIdList(int $id, MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, string $q = null,  int $length = 12): MemberServiceResponseList
    {
        $member = app()->call([$memberRepository, 'getByUserUserIdList'], compact('id', 'length', 'q'));
        if(count($member) == 0){
            $memberServiceResponseList->status = false;
            $memberServiceResponseList->message = "Data Not Found";
        }else{
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = "Data Found";
            $memberServiceResponseList->memberList = $member;
            $memberServiceResponseList->count = $member->total();
            $memberServiceResponseList->countFiltered = $member->count();
        }

        return $memberServiceResponseList;
    }

}
