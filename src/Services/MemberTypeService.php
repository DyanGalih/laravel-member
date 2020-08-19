<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services;

use WebAppId\Member\Repositories\MemberTypeRepository;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;
use WebAppId\Member\Services\Contracts\MemberTypeServiceContract;
use WebAppId\Member\Services\Requests\MemberTypeServiceRequest;
use WebAppId\Member\Services\Responses\MemberTypeServiceResponse;
use WebAppId\Member\Services\Responses\MemberTypeServiceResponseList;
use WebAppId\DDD\Services\BaseService;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeService
 * @package App\Services
 */
class MemberTypeService implements MemberTypeServiceContract
{

    /**
     * @inheritDoc
     */
    public function store(MemberTypeServiceRequest $memberTypeServiceRequest, MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse
    {
        $memberTypeRepositoryRequest = Lazy::copy($memberTypeServiceRequest, $memberTypeRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$memberTypeRepository, 'store'], ['memberTypeRepositoryRequest' => $memberTypeRepositoryRequest]);
        if ($result != null) {
            $memberTypeServiceResponse->status = true;
            $memberTypeServiceResponse->message = 'Store Data Success';
            $memberTypeServiceResponse->memberType = $result;
        } else {
            $memberTypeServiceResponse->status = false;
            $memberTypeServiceResponse->message = 'Store Data Failed';
        }

        return $memberTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, MemberTypeServiceRequest $memberTypeServiceRequest, MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse
    {
        $memberTypeRepositoryRequest = Lazy::copy($memberTypeServiceRequest, $memberTypeRepositoryRequest, Lazy::AUTOCAST);

        $result = app()->call([$memberTypeRepository, 'update'], ['id' => $id, 'memberTypeRepositoryRequest' => $memberTypeRepositoryRequest]);
        if ($result != null) {
            $memberTypeServiceResponse->status = true;
            $memberTypeServiceResponse->message = 'Update Data Success';
            $memberTypeServiceResponse->memberType = $result;
        } else {
            $memberTypeServiceResponse->status = false;
            $memberTypeServiceResponse->message = 'Update Data Failed';
        }

        return $memberTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponse $memberTypeServiceResponse): MemberTypeServiceResponse
    {
        $result = app()->call([$memberTypeRepository, 'getById'], ['id' => $id]);
        if ($result != null) {
            $memberTypeServiceResponse->status = true;
            $memberTypeServiceResponse->message = 'Data Found';
            $memberTypeServiceResponse->memberType = $result;
        } else {
            $memberTypeServiceResponse->status = false;
            $memberTypeServiceResponse->message = 'Data Not Found';
        }

        return $memberTypeServiceResponse;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, MemberTypeRepository $memberTypeRepository): bool
    {
        return app()->call([$memberTypeRepository, 'delete'], ['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function get(MemberTypeRepository $memberTypeRepository, MemberTypeServiceResponseList $memberTypeServiceResponseList, int $length = 12, string $q = null): MemberTypeServiceResponseList
    {
        $result = app()->call([$memberTypeRepository, 'get'], ['q' => $q]);
        if (count($result) > 0) {
            $memberTypeServiceResponseList->status = true;
            $memberTypeServiceResponseList->message = 'Data Found';
            $memberTypeServiceResponseList->memberTypeList = $result;
            $memberTypeServiceResponseList->count = app()->call([$memberTypeRepository, 'getCount']);
            $memberTypeServiceResponseList->countFiltered = $result->total();
        } else {
            $memberTypeServiceResponseList->status = false;
            $memberTypeServiceResponseList->message = 'Data Not Found';
        }
        return $memberTypeServiceResponseList;
    }

    /**
     * @inheritDoc
     */
    public function getCount(MemberTypeRepository $memberTypeRepository, string $q = null): int
    {
        return app()->call([$memberTypeRepository, 'getCount'], ['q' => $q]);
    }
}
