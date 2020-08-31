<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Content\Repositories\CategoryRepository;
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
    public function update(string $code,
                           MemberServiceRequest $memberServiceRequest,
                           ContentServiceRequest $contentServiceRequest,
                           MemberRepositoryRequest $memberRepositoryRequest,
                           ContentService $contentService,
                           CategoryRepository $categoryRepository,
                           MemberRepository $memberRepository,
                           MemberServiceResponse $memberServiceResponse,
                           int $ownerId = null): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @param int|null $ownerId
     * @return MemberServiceResponse
     */
    public function getByCode(string $code,
                              MemberRepository $memberRepository,
                              MemberServiceResponse $memberServiceResponse,
                              int $ownerId = null): MemberServiceResponse;

    /**
     * @param int $profileId
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @param int|null $ownerId
     * @return MemberServiceResponse
     */
    public function getByProfileId(int $profileId,
                                   MemberRepository $memberRepository,
                                   MemberServiceResponse $memberServiceResponse,
                                   int $ownerId = null): MemberServiceResponse;

    /**
     * @param int $id
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponse $memberServiceResponse
     * @param int|null $ownerId
     * @return MemberServiceResponse
     */
    public function getById(int $id,
                            MemberRepository $memberRepository,
                            MemberServiceResponse $memberServiceResponse,
                            int $ownerId = null): MemberServiceResponse;

    /**
     * @param string $code
     * @param MemberRepository $memberRepository
     * @param int|null $ownerId
     * @return bool
     */
    public function delete(string $code,
                           MemberRepository $memberRepository,
                           int $ownerId = null): bool;

    /**
     * @param MemberRepository $memberRepository
     * @param MemberServiceResponseList $memberServiceResponseList
     * @param int $length
     * @param string|null $q
     * @param int|null $ownerId
     * @return MemberServiceResponseList
     */
    public function get(MemberRepository $memberRepository,
                        MemberServiceResponseList $memberServiceResponseList,
                        int $length = 12,
                        string $q = null,
                        int $ownerId = null): MemberServiceResponseList;

    /**
     * @param MemberRepository $memberRepository
     * @param string|null $q
     * @param int|null $ownerId
     * @return int
     */
    public function getCount(MemberRepository $memberRepository,
                             string $q = null, int $ownerId = null): int;
}
