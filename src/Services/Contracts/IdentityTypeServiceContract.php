<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Member\Repositories\IdentityTypeRepository;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;
use WebAppId\Member\Services\Requests\IdentityTypeServiceRequest;
use WebAppId\Member\Services\Responses\IdentityTypeServiceResponse;
use WebAppId\Member\Services\Responses\IdentityTypeServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeServiceContract
 * @package WebAppId\Member\Services\Contracts
 */
interface IdentityTypeServiceContract
{
    /**
     * @param IdentityTypeServiceRequest $identityTypeServiceRequest
     * @param IdentityTypeRepositoryRequest $identityTypeRepositoryRequest
     * @param IdentityTypeRepository $identityTypeRepository
     * @param IdentityTypeServiceResponse $identityTypeServiceResponse
     * @return IdentityTypeServiceResponse
     */
    public function store(IdentityTypeServiceRequest $identityTypeServiceRequest, IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse;

    /**
     * @param int $id
     * @param IdentityTypeServiceRequest $identityTypeServiceRequest
     * @param IdentityTypeRepositoryRequest $identityTypeRepositoryRequest
     * @param IdentityTypeRepository $identityTypeRepository
     * @param IdentityTypeServiceResponse $identityTypeServiceResponse
     * @return IdentityTypeServiceResponse
     */
    public function update(int $id, IdentityTypeServiceRequest $identityTypeServiceRequest, IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse;

    /**
     * @param int $id
     * @param IdentityTypeRepository $identityTypeRepository
     * @param IdentityTypeServiceResponse $identityTypeServiceResponse
     * @return IdentityTypeServiceResponse
     */
    public function getById(int $id, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse;

    /**
     * @param int $id
     * @param IdentityTypeRepository $identityTypeRepository
     * @return bool
     */
    public function delete(int $id, IdentityTypeRepository $identityTypeRepository): bool;

    /**
     * @param string $q
     * @param IdentityTypeRepository $identityTypeRepository
     * @param IdentityTypeServiceResponseList $identityTypeServiceResponseList
     * @param int $length
     * @return IdentityTypeServiceResponseList
     */
    public function get(IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponseList $identityTypeServiceResponseList,int $length = 12, string $q = null): IdentityTypeServiceResponseList;

    /**
     * @param string $q
     * @param IdentityTypeRepository $identityTypeRepository
     * @return int
     */
    public function getCount(IdentityTypeRepository $identityTypeRepository, string $q = null):int;
}
