<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Member\Repositories\MemberTypeRepository;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberTypeServiceRequest;
use WebAppId\Member\Services\Responses\MemberTypeServiceResponse;
use WebAppId\Member\Services\Responses\MemberTypeServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeServiceContract
 * @package App\Services\Contracts
 */
interface MemberTypeServiceContract
{
    /**
     * @param MemberTypeServiceRequest $memberTypeServiceRequest
     * @param MemberTypeRepositoryRequest $memberTypeRepositoryRequest
     * @param MemberTypeRepository $memberTypeRepository
     * @param MemberTypeServiceResponse $memberTypeServiceResponse
     * @return MemberTypeServiceResponse
     */
    public function store(MemberTypeServiceRequest $memberTypeServiceRequest, MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse;

    /**
     * @param int $id
     * @param MemberTypeServiceRequest $memberTypeServiceRequest
     * @param MemberTypeRepositoryRequest $memberTypeRepositoryRequest
     * @param MemberTypeRepository $memberTypeRepository
     * @param MemberTypeServiceResponse $memberTypeServiceResponse
     * @return MemberTypeServiceResponse
     */
    public function update(int $id, MemberTypeServiceRequest $memberTypeServiceRequest, MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse;

    /**
     * @param int $id
     * @param MemberTypeRepository $memberTypeRepository
     * @param MemberTypeServiceResponse $memberTypeServiceResponse
     * @return MemberTypeServiceResponse
     */
    public function getById(int $id, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse;

    /**
     * @param int $id
     * @param MemberTypeRepository $memberTypeRepository
     * @return bool
     */
    public function delete(int $id, MemberTypeRepository $memberTypeRepository): bool;

    /**
     * @param string $q
     * @param MemberTypeRepository $memberTypeRepository
     * @param MemberTypeServiceResponseList $memberTypeServiceResponseList
     * @param int $length
     * @return MemberTypeServiceResponseList
     */
    public function get(MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponseList $memberTypeServiceResponseList,int $length = 12, string $q = null): MemberTypeServiceResponseList;

    /**
     * @param string $q
     * @param MemberTypeRepository $memberTypeRepository
     * @return int
     */
    public function getCount(MemberTypeRepository $memberTypeRepository, string $q = null):int;
}
