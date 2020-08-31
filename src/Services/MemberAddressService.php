<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use Ramsey\Uuid\Uuid;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Repositories\MemberAddressRepository;
use WebAppId\Member\Repositories\MemberRepository;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;
use WebAppId\Member\Services\Contracts\MemberAddressServiceContract;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponse;
use WebAppId\Member\Services\Responses\MemberAddressServiceResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressService
 * @package WebAppId\Member\Services
 */
class MemberAddressService implements MemberAddressServiceContract
{

    /**
     * @inheritDoc
     */
    public function store(string $code,
                          MemberAddressServiceRequest $memberAddressServiceRequest,
                          MemberAddressRepositoryRequest $memberAddressRepositoryRequest,
                          MemberRepository $memberRepository,
                          MemberAddressRepository $memberAddressRepository,
                          MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {

        $memberAddressServiceRequest->code = Uuid::uuid4()->toString();

        $memberAddressRepositoryRequest = Lazy::copy($memberAddressServiceRequest, $memberAddressRepositoryRequest);

        $member = app()->call([$memberRepository, 'getByCode'], compact('code'));
        if ($member == null) {
            $memberAddressServiceResponse->status = false;
            $memberAddressServiceResponse->message = 'Store Data Failed';
            return $memberAddressServiceResponse;
        } else {
            $memberAddressRepositoryRequest->member_id = $member->id;
        }

        $result = app()->call([$memberAddressRepository, 'store'], ['memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
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
    public function update(string $identity, string $code, MemberAddressServiceRequest $memberAddressServiceRequest, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {
        $memberAddressServiceRequest->code = $code;

        $memberAddressRepositoryRequest = Lazy::copy($memberAddressServiceRequest, $memberAddressRepositoryRequest);

        $result = app()->call([$memberAddressRepository, 'update'], ['code' => $code, 'memberAddressRepositoryRequest' => $memberAddressRepositoryRequest]);
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
    public function getByCode(string $memberCode, string $code, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponse $memberAddressServiceResponse): MemberAddressServiceResponse
    {
        $result = app()->call([$memberAddressRepository, 'getByCode'], ['code' => $code]);

        if ($result != null && $result->member_code == $memberCode) {
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
    public function delete(string $memberCode, string $code,
                           MemberAddressRepository $memberAddressRepository,
                           MemberAddressServiceResponse $memberAddressServiceResponse): bool
    {
        $memberAddress = $this->getByCode($memberCode, $code, $memberAddressRepository, $memberAddressServiceResponse);
        if (!$memberAddress->status) {
            return false;
        } else {
            return app()->call([$memberAddressRepository, 'delete'], ['code' => $code]);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $identity, MemberAddressRepository $memberAddressRepository, MemberAddressServiceResponseList $memberAddressServiceResponseList, int $length = 12, string $q = null): MemberAddressServiceResponseList
    {
        $result = app()->call([$memberAddressRepository, 'get'], compact('q', 'identity'));
        if (count($result) > 0) {
            $memberAddressServiceResponseList->status = true;
            $memberAddressServiceResponseList->message = 'Data Found';
            $memberAddressServiceResponseList->memberAddressList = $result;
            $memberAddressServiceResponseList->count = app()->call([$memberAddressRepository, 'getCount'], compact('identity'));
            $memberAddressServiceResponseList->countFiltered = $result->total();
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
        return app()->call([$memberAddressRepository, 'getCount'], compact('q', 'identity'));
    }
}
