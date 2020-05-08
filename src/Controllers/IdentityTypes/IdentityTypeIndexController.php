<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\IdentityTypes;

use WebAppId\Member\Requests\IdentityTypeSearchRequest;
use WebAppId\Member\Services\IdentityTypeService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeIndexController
 * @package WebAppId\Member\Controllers\IdentityTypes
 */
class IdentityTypeIndexController extends BaseController
{
    /**
     * @param IdentityTypeSearchRequest $identityTypeSearchRequest
     * @param IdentityTypeService $identityTypeService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(
                             IdentityTypeSearchRequest $identityTypeSearchRequest,
                             IdentityTypeService $identityTypeService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $searchValue = $identityTypeSearchRequest->validated();
        $q = "";
        if(!empty($searchValue)) {
            if(isset($searchValue['q'])) {
                $q = $searchValue['q'];
            }else{
                $q = $searchValue['search']['value'] != null ? $searchValue['search']['value'] : '';
            }
        }

        $result = $this->container->call([$identityTypeService, 'getWhere'], ['q' => $q]);

        if ($result->isStatus()) {
            $response->setData($result->identityTypeList);
            $response->setRecordsTotal($result->count);
            $response->setRecordsFiltered($result->countFiltered);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
