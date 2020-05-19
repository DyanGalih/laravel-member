<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Content\Repositories\ContentRepository;
use WebAppId\Content\Repositories\Requests\ContentRepositoryRequest;
use WebAppId\Content\Services\ContentService;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use WebAppId\Member\Services\Responses\MemberServiceResponse;
use WebAppId\Member\Services\Responses\MemberServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceContract
 * @package WebAppId\Member\Services\Contracts
 */
interface MemberServiceContract
{
    /**
     * @param MemberServiceRequest $memberServiceRequest
     * @param ContentServiceRequest $contentServiceRequest
     * @param ContentService $contentService
     * @param CategoryRepository $categoryRepository
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function store(MemberServiceRequest $memberServiceRequest,
                          ContentServiceRequest $contentServiceRequest,
                          ContentService $contentService,
                          CategoryRepository $categoryRepository,
                          MemberRepositoryRequest $memberRepositoryRequest,
                          MemberRepository $memberRepository,
                          MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberServiceRequest $memberServiceRequest
     * @param MemberRepositoryRequest $memberRepositoryRequest
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function update(int $id, MemberServiceRequest $memberServiceRequest, MemberRepositoryRequest $memberRepositoryRequest, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param string $identity
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @return MemberServiceResponse
     */
    public function getByIdentity(string $identity, MemberRepository $memberRepository, MemberServiceResponse $memberServiceResponse): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @return bool
     */
    public function delete(int $id, MemberRepository $memberRepository): bool;

    /**
     * @param string $q
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param int $length
     * @return MemberServiceResponseList
     */
    public function get(MemberRepository $memberRepository, MemberServiceResponseList $memberServiceResponseList,int $length = 12, string $q = null): MemberServiceResponseList;

    /**
     * @param string $q
     * @param MemberRepository $memberRepository
     * @return int
     */
    public function getCount(MemberRepository $memberRepository, string $q = null):int;
}
