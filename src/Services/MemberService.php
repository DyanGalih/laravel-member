<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Member\Repositories\MemberRepository;
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
    public function store(MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);

        $result = $this->container->call([$memberRepository, 'store'], ['memberRepositoryRequest' => $memberRepositoryRequest]);
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
    public function update(int $id, MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $memberRepositoryRequest = Lazy::copy($memberServiceRequest, $memberRepositoryRequest);

        $result = $this->container->call([$memberRepository, 'update'], ['id' => $id, 'memberRepositoryRequest' => $memberRepositoryRequest]);
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
    public function getById(int $id, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse
    {
        $result = $this->container->call([$memberRepository, 'getById'], ['id' => $id]);
        if ($result != null) {
            $memberServiceResponse->status = true;
            $memberServiceResponse->message = 'Data Found';
            $memberServiceResponse->member = $result;
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
