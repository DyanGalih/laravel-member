<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Member\Repositories\AddressTypeRepository;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;
use WebAppId\Member\Services\Requests\AddressTypeServiceRequest;
use WebAppId\Member\Services\Responses\AddressTypeServiceResponse;
use WebAppId\Member\Services\Responses\AddressTypeServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeServiceContract
 * @package WebAppId\Member\Services\Contracts
 */
interface AddressTypeServiceContract
{
    /**
     * @param AddressTypeServiceRequest $addressTypeServiceRequest
     * @param AddressTypeRepositoryRequest $addressTypeRepositoryRequest
     * @param AddressTypeRepository $addressTypeRepository
     * @param AddressTypeServiceResponse $addressTypeServiceResponse
     * @return AddressTypeServiceResponse
     */
    public function store(AddressTypeServiceRequest $addressTypeServiceRequest, AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse;

    /**
     * @param int $id
     * @param AddressTypeServiceRequest $addressTypeServiceRequest
     * @param AddressTypeRepositoryRequest $addressTypeRepositoryRequest
     * @param AddressTypeRepository $addressTypeRepository
     * @param AddressTypeServiceResponse $addressTypeServiceResponse
     * @return AddressTypeServiceResponse
     */
    public function update(int $id, AddressTypeServiceRequest $addressTypeServiceRequest, AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse;

    /**
     * @param int $id
     * @param AddressTypeRepository $addressTypeRepository
     * @param AddressTypeServiceResponse $addressTypeServiceResponse
     * @return AddressTypeServiceResponse
     */
    public function getById(int $id, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse;

    /**
     * @param string $name
     * @param AddressTypeRepository $addressTypeRepository
     * @param AddressTypeServiceResponse $addressTypeServiceResponse
     * @return AddressTypeServiceResponse
     */
    public function getByName(string $name, AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponse $addressTypeServiceResponse): AddressTypeServiceResponse;

    /**
     * @param int $id
     * @param AddressTypeRepository $addressTypeRepository
     * @return bool
     */
    public function delete(int $id, AddressTypeRepository $addressTypeRepository): bool;

    /**
     * @param string $q
     * @param AddressTypeRepository $addressTypeRepository
     * @param AddressTypeServiceResponseList $addressTypeServiceResponseList
     * @param int $length
     * @return AddressTypeServiceResponseList
     */
    public function get(AddressTypeRepository $addressTypeRepository, AddressTypeServiceResponseList $addressTypeServiceResponseList, int $length = 12, string $q = null): AddressTypeServiceResponseList;

    /**
     * @param string $q
     * @param AddressTypeRepository $addressTypeRepository
     * @return int
     */
    public function getCount(AddressTypeRepository $addressTypeRepository, string $q = null): int;
}
