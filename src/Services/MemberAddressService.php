<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;
use WebAppId\Member\Services\Contracts\MemberAddressServiceContract;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponse;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponseList;
use WebAppId\DDD\Services\BaseService;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressService
 * @package WebAppId\Member\Services
 */
class MemberAddressService extends BaseService implements MemberAddressServiceContract
{

    /**
     * @inheritDoc
     */
    public function store(MemberAddressServiceRequest $memberAddressServiceRequest, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {
        $memberAddressRepositoryRequest = Lazy::copy($memberAddressServiceRequest, $memberAddressRepositoryRequest);

        $result = $this->container->call([$memberAddressRepository, 'store'], ['memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
        if ($result != null) {
            $memberAddressServiceResponse->status = true;
            $memberAddressServiceResponse->message = 'Store Data Success';
            $memberAddressServiceResponse->memberAddress = $result;
        } else {
            $memberAddressServiceResponse->status = false;
            $memberAddressServiceResponse->message = 'Store Data Failed';
        }

        return $memberAddressServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function update(string $code, MemberAddressServiceRequest $memberAddressServiceRequest, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {
        $memberAddressRepositoryRequest = Lazy::copy($memberAddressServiceRequest, $memberAddressRepositoryRequest);

        $result = $this->container->call([$memberAddressRepository, 'update'], ['code' => $code, 'memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
        if ($result != null) {
            $memberAddressServiceResponse->status = true;
            $memberAddressServiceResponse->message = 'Update Data Success';
            $memberAddressServiceResponse->memberAddress = $result;
        } else {
            $memberAddressServiceResponse->status = false;
            $memberAddressServiceResponse->message = 'Update Data Failed';
        }

        return $memberAddressServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getByCode(string $code, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {
        $result = $this->container->call([$memberAddressRepository, 'getByCode'], ['code' => $code]);
        if ($result != null) {
            $memberAddressServiceResponse->status = true;
            $memberAddressServiceResponse->message = 'Data Found';
            $memberAddressServiceResponse->memberAddress = $result;
        } else {
            $memberAddressServiceResponse->status = false;
            $memberAddressServiceResponse->message = 'Data Not Found';
        }

        return $memberAddressServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $code, MemberAddressRepository $memberAddressRepository): bool
    {
        return $this->container->call([$memberAddressRepository, 'delete'], ['code' => $code]);
    }

    /**
     * @inheritDoc
     */
    public function get(string $identity, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponseList $memberAddressServiceResponseList, int $length = 12, string $q = null): MemberAddressServiceResponseList
    {
        $result = $this->container->call([$memberAddressRepository, 'get'], compact('q', 'identity'));
        if (count($result) > 0) {
            $memberAddressServiceResponseList->status = true;
            $memberAddressServiceResponseList->message = 'Data Found';
            $memberAddressServiceResponseList->memberAddressList = $result;
            $memberAddressServiceResponseList->count = $this->container->call([$memberAddressRepository, 'getCount'], compact('identity'));
            $memberAddressServiceResponseList->countFiltered = $this->container->call([$memberAddressRepository, 'getCount'], compact('q', 'identity'));
        } else {
            $memberAddressServiceResponseList->status = false;
            $memberAddressServiceResponseList->message = 'Data Not Found';
        }
        return $memberAddressServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getCount(string $identity, MemberAddressRepository $memberAddressRepository, string $q = null): int
    {
        return $this->container->call([$memberAddressRepository, 'getCount'], compact('q', 'identity'));
    }
}
