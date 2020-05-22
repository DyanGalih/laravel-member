<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Member\Repositories\MemberRepository;
use Illuminate\Support\Facades\DB;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Contracts\MemberServiceContract;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use WebAppId\Member\Services\Responses\MemberServiceResponseList;
use WebAppId\DDD\Services\BaseService;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberService
 * @package WebAppId\Member\Services
 */
class MemberService extends BaseService implements MemberServiceContract
{
    /**
     * @inheritDoc
     */
    public function store(MemberServiceRequest $memberServiceRequest,
                          ContentServiceRequest $contentServiceRequest,
                          ContentService $contentService,
                          CategoryRepository $categoryRepository,
                          MemberRepositoryRequest $memberRepositoryRequest,
                          MemberRepository $memberRepository,
                          MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        DB::beginTransaction();
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);
        $category = $this->container->call([$categoryRepository, 'getByName'], ['name' => 'Profile']);
        if ($category != null) {
            $contentServiceRequest->categories[] = $category->id;
        }
        if ($contentServiceRequest->content == null) {
            $contentServiceRequest->content = '';
        }
        $resultContent = $this->container->call([$contentService, 'store'], compact('contentServiceRequest'));

        $memberRepositoryRequest->content_id = $resultContent->content->id;

        $result = $this->container->call([$memberRepository, 'store'], compact('memberRepositoryRequest'));

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
    public function update(int $id,
                           MemberServiceRequest $memberServiceRequest,
                           ContentServiceRequest $contentServiceRequest,
                           MemberRepositoryRequest $memberRepositoryRequest,
                           ContentService $contentService,
                           MemberRepository $memberRepository,
                           MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        DB::beginTransaction();
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);

        $code = $contentServiceRequest->code;

        $resultContent = $this->container->call([$contentService, 'update'], compact('code', 'contentServiceRequest'));

        $result = $this->container->call([$memberRepository, 'update'], ['id' => $id, 'memberRepositoryRequest' => $memberRepositoryRequest]);
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

    /**
     * @inheritDoc
     */
    public function getByIdentity(string $identity, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $result = $this->container->call([$memberRepository, 'getByIdentity'], ['identity' => $identity]);
        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Data Found';
            $memberServiceResponse->member = $result;
            $memberServiceResponse->addressList = $result->addresses;
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Data Not Found';
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $result = $this->container->call([$memberRepository, 'getById'], compact('id'));
        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Data Found';
            $memberServiceResponse->member = $result;
            $memberServiceResponse->addressList = $result->addresses;
        } else {
            $memberServiceResponse->status = false;
            $memberServiceResponse->message = 'Data Not Found';
        }

        return $memberServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, MemberRepository $memberRepository): bool
    {
        return $this->container->call([$memberRepository, 'delete'], ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function get(MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList, int $length = 12, string $q = null): MemberServiceResponseList
    {
        $result = $this->container->call([$memberRepository, 'get'], ['q' => $q]);
        if (count($result) > 0) {
            $memberServiceResponseList->status = true;
            $memberServiceResponseList->message = 'Data Found';
            $memberServiceResponseList->memberList = $result;
            $memberServiceResponseList->count = $this->container->call([$memberRepository, 'getCount']);
            $memberServiceResponseList->countFiltered = $this->container->call([$memberRepository, 'getCount'], ['q' => $q]);
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
        return $this->container->call([$memberRepository, 'getCount'], ['q' => $q]);
    }
}
