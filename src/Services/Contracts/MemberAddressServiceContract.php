<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Contracts;

use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponse;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressServiceContract
 * @package WebAppId\Member\Services\Contracts
 */
interface MemberAddressServiceContract
{
    /**
     * @param MemberAddressServiceRequest $memberAddressServiceRequest
     * @param MemberAddressRepositoryRequest $memberAddressRepositoryRequest
     * @param MemberAddressRepository $memberAddressRepository
     * @param MemberAddressServiceResponse $memberAddressServiceResponse
     * @return MemberAddressServiceResponse
     */
    public function store(MemberAddressServiceRequest $memberAddressServiceRequest, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse;

    /**
     * @param string $code
     * @param MemberAddressServiceRequest $memberAddressServiceRequest
     * @param MemberAddressRepositoryRequest $memberAddressRepositoryRequest
     * @param MemberAddressRepository $memberAddressRepository
     * @param MemberAddressServiceResponse $memberAddressServiceResponse
     * @return MemberAddressServiceResponse
     */
    public function update(string $code, MemberAddressServiceRequest $memberAddressServiceRequest, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse;

    /**
     * @param string $code
     * @param MemberAddressRepository $memberAddressRepository
     * @param MemberAddressServiceResponse $memberAddressServiceResponse
     * @return MemberAddressServiceResponse
     */
    public function getByCode(string $code, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse;

    /**
     * @param string $code
     * @param MemberAddressRepository $memberAddressRepository
     * @return bool
     */
    public function delete(string $code, MemberAddressRepository $memberAddressRepository): bool;

    /**
     * @param string $identity
     * @param MemberAddressRepository $memberAddressRepository
     * @param MemberAddressServiceResponseList $memberAddressServiceResponseList
     * @param int $length
     * @param string $q
     * @return MemberAddressServiceResponseList
     */
    public function get(string $identity, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponseList $memberAddressServiceResponseList,int $length = 12, string $q = null): MemberAddressServiceResponseList;

    /**
     * @param string $identity
     * @param MemberAddressRepository $memberAddressRepository
     * @param string $q
     * @return int
     */
    public function getCount(string $identity, MemberAddressRepository $memberAddressRepository, string $q = null):int;
}
