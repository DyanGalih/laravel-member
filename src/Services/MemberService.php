<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Services\Contracts\MemberServiceContract;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use Illuminate\Support\Facades\DB;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
 * Class MemberService
 * @package WebAppId\Member\Services
 */
class MemberService implements MemberServiceContract
{
    use MemberServiceTrait{
        store as baseStore;
        update as baseUpdate;
    }

    /**
     * @inheritDoc
     * MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse
     */
    public function store(MemberServiceRequest $memberServiceRequest,
                          MemberRepositoryRequest $memberRepositoryRequest,
                          MemberRepository $memberRepository,
                          MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        DB::beginTransaction();
        $contentServiceRequest = app()->make(ContentServiceRequest::class);
        $contentService = app()->make(ContentService::class);
        $categoryRepository = app()->make(CategoryRepository::class);
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
     * @inheritDoc
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
