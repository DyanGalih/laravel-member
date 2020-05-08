<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Member\Repositories\IdentityTypeRepository;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;
use WebAppId\Member\Services\Contracts\IdentityTypeServiceContract;
use WebAppId\Member\Services\Requests\IdentityTypeServiceRequest;
use WebAppId\Member\Services\Responses\IdentityTypeServiceResponse;
use WebAppId\Member\Services\Responses\IdentityTypeServiceResponseList;
use WebAppId\DDD\Services\BaseService;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeService
 * @package WebAppId\Member\Services
 */
class IdentityTypeService extends BaseService implements IdentityTypeServiceContract
{

    /**
     * @inheritDoc
     */
    public function store(IdentityTypeServiceRequest $identityTypeServiceRequest, IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse
    {
        $identityTypeRepositoryRequest = Lazy::copy($identityTypeServiceRequest, $identityTypeRepositoryRequest);

        $result = $this->container->call([$identityTypeRepository, 'store'], ['identityTypeRepositoryRequest' => $identityTypeRepositoryRequest]);
        if ($result != null) {
            $identityTypeServiceResponse->status = true;
            $identityTypeServiceResponse->message = 'Store Data Success';
            $identityTypeServiceResponse->identityType = $result;
        } else {
            $identityTypeServiceResponse->status = false;
            $identityTypeServiceResponse->message = 'Store Data Failed';
        }

        return $identityTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, IdentityTypeServiceRequest $identityTypeServiceRequest, IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse
    {
        $identityTypeRepositoryRequest = Lazy::copy($identityTypeServiceRequest, $identityTypeRepositoryRequest);

        $result = $this->container->call([$identityTypeRepository, 'update'], ['id' => $id, 'identityTypeRepositoryRequest' => $identityTypeRepositoryRequest]);
        if ($result != null) {
            $identityTypeServiceResponse->status = true;
            $identityTypeServiceResponse->message = 'Update Data Success';
            $identityTypeServiceResponse->identityType = $result;
        } else {
            $identityTypeServiceResponse->status = false;
            $identityTypeServiceResponse->message = 'Update Data Failed';
        }

        return $identityTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponse $identityTypeServiceResponse): IdentityTypeServiceResponse
    {
        $result = $this->container->call([$identityTypeRepository, 'getById'], ['id' => $id]);
        if ($result != null) {
            $identityTypeServiceResponse->status = true;
            $identityTypeServiceResponse->message = 'Data Found';
            $identityTypeServiceResponse->identityType = $result;
        } else {
            $identityTypeServiceResponse->status = false;
            $identityTypeServiceResponse->message = 'Data Not Found';
        }

        return $identityTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, IdentityTypeRepository $identityTypeRepository): bool
    {
        return $this->container->call([$identityTypeRepository, 'delete'], ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function get(IdentityTypeRepository $identityTypeRepository, IdentityTypeServiceResponseList $identityTypeServiceResponseList, int $length = 12, string $q = null): IdentityTypeServiceResponseList
    {
        $result = $this->container->call([$identityTypeRepository, 'get'], ['q' => $q]);
        if (count($result) > 0) {
            $identityTypeServiceResponseList->status = true;
            $identityTypeServiceResponseList->message = 'Data Found';
            $identityTypeServiceResponseList->identityTypeList = $result;
            $identityTypeServiceResponseList->count = $this->container->call([$identityTypeRepository, 'getCount']);
            $identityTypeServiceResponseList->countFiltered = $this->container->call([$identityTypeRepository, 'getCount'], ['q' => $q]);
        } else {
            $identityTypeServiceResponseList->status = false;
            $identityTypeServiceResponseList->message = 'Data Not Found';
        }
        return $identityTypeServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getCount(IdentityTypeRepository $identityTypeRepository, string $q = null): int
    {
        return $this->container->call([$identityTypeRepository, 'getCount'], ['q' => $q]);
    }
}
