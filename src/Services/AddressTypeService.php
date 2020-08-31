<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Repositories\AddressTypeRepository;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;
use WebAppId\Member\Services\Contracts\AddressTypeServiceContract;
use WebAppId\Member\Services\Requests\AddressTypeServiceRequest;
use WebAppId\Member\Services\Responses\AddressTypeServiceResponse;
use WebAppId\Member\Services\Responses\AddressTypeServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeService
 * @package WebAppId\Member\Services
 */
class AddressTypeService implements AddressTypeServiceContract
{

    /**
     * @inheritDoc
     */
    public function store(AddressTypeServiceRequest $addressTypeServiceRequest, AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse
    {
        $addressTypeRepositoryRequest = Lazy::copy($addressTypeServiceRequest, $addressTypeRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$addressTypeRepository, 'store'], ['addressTypeRepositoryRequest' => $addressTypeRepositoryRequest]);
        if ($result != null) {
            $addressTypeServiceResponse->status = true;
            $addressTypeServiceResponse->message = 'Store Data Success';
            $addressTypeServiceResponse->addressType = $result;
        } else {
            $addressTypeServiceResponse->status = false;
            $addressTypeServiceResponse->message = 'Store Data Failed';
        }

        return $addressTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, AddressTypeServiceRequest $addressTypeServiceRequest, AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse
    {
        $addressTypeRepositoryRequest = Lazy::copy($addressTypeServiceRequest, $addressTypeRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$addressTypeRepository, 'update'], ['id' => $id, 'addressTypeRepositoryRequest' => $addressTypeRepositoryRequest]);
        if ($result != null) {
            $addressTypeServiceResponse->status = true;
            $addressTypeServiceResponse->message = 'Update Data Success';
            $addressTypeServiceResponse->addressType = $result;
        } else {
            $addressTypeServiceResponse->status = false;
            $addressTypeServiceResponse->message = 'Update Data Failed';
        }

        return $addressTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse
    {
        $result = app()->call([$addressTypeRepository, 'getById'], ['id' => $id]);
        if ($result != null) {
            $addressTypeServiceResponse->status = true;
            $addressTypeServiceResponse->message = 'Data Found';
            $addressTypeServiceResponse->addressType = $result;
        } else {
            $addressTypeServiceResponse->status = false;
            $addressTypeServiceResponse->message = 'Data Not Found';
        }

        return $addressTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse
    {
        $result = app()->call([$addressTypeRepository, 'getByName'], ['name' => $name]);
        if ($result != null) {
            $addressTypeServiceResponse->status = true;
            $addressTypeServiceResponse->message = 'Data Found';
            $addressTypeServiceResponse->addressType = $result;
        } else {
            $addressTypeServiceResponse->status = false;
            $addressTypeServiceResponse->message = 'Data Not Found';
        }

        return $addressTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, AddressTypeRepository $addressTypeRepository): bool
    {
        return app()->call([$addressTypeRepository, 'delete'], ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function get(AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponseList $addressTypeServiceResponseList, int $length = 12, string $q = null): AddressTypeServiceResponseList
    {
        $result = app()->call([$addressTypeRepository, 'get'], ['q' => $q]);
        if (count($result) > 0) {
            $addressTypeServiceResponseList->status = true;
            $addressTypeServiceResponseList->message = 'Data Found';
            $addressTypeServiceResponseList->addressTypeList = $result;
            $addressTypeServiceResponseList->count = app()->call([$addressTypeRepository, 'getCount']);
            $addressTypeServiceResponseList->countFiltered = $result->total();
        } else {
            $addressTypeServiceResponseList->status = false;
            $addressTypeServiceResponseList->message = 'Data Not Found';
        }
        return $addressTypeServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getCount(AddressTypeRepository $addressTypeRepository, string $q = null): int
    {
        return app()->call([$addressTypeRepository, 'getCount'], ['q' => $q]);
    }
}
