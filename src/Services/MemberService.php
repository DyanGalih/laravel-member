<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Contracts\MemberServiceContract;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
 * Class MemberService
 * @package WebAppId\Member\Services
 */
class MemberService implements MemberServiceContract
{
    use MemberServiceTrait {
        store as baseStore;
        update as baseUpdate;
    }

    /**
     * @param MemberServiceRequest $memberServiceRequest
     * @param ContentServiceRequest $contentServiceRequest
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param ContentService $contentService
     * @param CategoryRepository $categoryRepository
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function storeMember(MemberServiceRequest $memberServiceRequest,
                                ContentServiceRequest $contentServiceRequest,
                                MemberRepositoryRequest $memberRepositoryRequest,
                                ContentService $contentService,
                                CategoryRepository $categoryRepository,
                                MemberRepository $memberRepository,
                                MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        DB::beginTransaction();

        $availableMember = app()->call([$memberRepository, 'getByEmail'], ['email' => $memberServiceRequest->email]);

        if ($availableMember != null) {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Email already used. Choose another one';
            return $memberServiceResponse;
        }

        if ($memberServiceRequest->code == null) {
            $memberServiceRequest->code = Str::uuid();
        }

        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);
        $category = app()->call([$categoryRepository, 'getByName'], ['name' => 'Profile']);
        if ($category != null) {
            $contentServiceRequest->categories[] = $category->id;
        }
        if ($contentServiceRequest->content == null) {
            $contentServiceRequest->content = '';
        }

        $resultContent = app()->call([$contentService, 'store'], compact('contentServiceRequest'));

        $memberRepositoryRequest->content_id = $resultContent->content->id;

        $result = app()->call([$memberRepository, 'store'], compact('memberRepositoryRequest'));

        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Store Data Success';
            $memberServiceResponse->member = $result;
            $memberServiceResponse->content = $resultContent->content;
            $memberServiceResponse->categories = $resultContent->categories;
            $memberServiceResponse->galleries = $resultContent->galleries;
            $memberServiceResponse->children = $resultContent->children;
            DB::commit();
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Store Data Failed';
            DB::rollback();
        }

        return $memberServiceResponse;
    }

    /**
     * @param string $code
     * @param MemberServiceRequest $memberServiceRequest
     * @param ContentServiceRequest $contentServiceRequest
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param ContentService $contentService
     * @param CategoryRepository $categoryRepository
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @param int|null $ownerId
     * @return MemberServiceResponse
     */
    public function privateUpdate(string $code,
                                  MemberServiceRequest $memberServiceRequest,
                                  ContentServiceRequest $contentServiceRequest,
                                  MemberRepositoryRequest $memberRepositoryRequest,
                                  ContentService $contentService,
                                  CategoryRepository $categoryRepository,
                                  MemberRepository $memberRepository,
                                  MemberServiceResponse $memberServiceResponse,
                                  int $ownerId = null): MemberServiceResponse
    {
        DB::beginTransaction();

        $availableMember = app()->call([$memberRepository, 'getByEmail'], ['email' => $memberServiceRequest->email]);

        if ($availableMember != null && $availableMember->code != $code) {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Email already used. Choose another one';
            return $memberServiceResponse;
        }

        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);

        $member = app()->call([$memberRepository, 'getByCode'], compact('code', 'ownerId'));

        $contentCode = $member->content_code;

        $category = app()->call([$categoryRepository, 'getByName'], ['name' => 'Profile']);
        if ($category != null) {
            $contentServiceRequest->categories[] = $category->id;
        }
        if ($contentServiceRequest->content == null) {
            $contentServiceRequest->content = '';
        }

        $resultContent = app()->call([$contentService, 'update'], ['code' => $contentCode, 'contentServiceRequest' => $contentServiceRequest, 'ownerId' => $ownerId]);

        $memberRepositoryRequest->content_id = $resultContent->content->id;

        $result = app()->call([$memberRepository, 'update'], compact('code', 'memberRepositoryRequest', 'ownerId'));

        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Update Data Success';
            $memberServiceResponse->member = $result;
            $memberServiceResponse->content = $resultContent->content;
            $memberServiceResponse->categories = $resultContent->categories;
            $memberServiceResponse->galleries = $resultContent->galleries;
            $memberServiceResponse->children = $resultContent->children;
            DB::commit();
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Update Data Failed';
            DB::rollback();
        }

        return $memberServiceResponse;
    }
}
