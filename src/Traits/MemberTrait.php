<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Lazy\Tools\Lazy;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 02/04/2021
 * Time: 11.08
 * Class MemberTrait
 * @package ${NAMESPACE}
 */
trait MemberTrait
{
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
    protected function storeMemberContent(MemberServiceRequest $memberServiceRequest,
                                          ContentServiceRequest $contentServiceRequest,
                                          MemberRepositoryRequest $memberRepositoryRequest,
                                          ContentService $contentService,
                                          CategoryRepository $categoryRepository,
                                          MemberRepository $memberRepository,
                                          MemberServiceResponse $memberServiceResponse)
    {
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
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Store Data Failed';
        }

        return $memberServiceResponse;
    }
}
