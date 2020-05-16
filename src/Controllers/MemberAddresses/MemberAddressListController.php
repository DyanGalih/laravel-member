<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\MemberAddresses;

use WebAppId\Member\Requests\MemberAddressSearchRequest;
use WebAppId\Member\Services\MemberAddressService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 11:55:32
 * Time: 2020/05/09
 * Class MemberAddressListController
 * @package WebAppId\Member\Controllers\MemberAddresses
 */
class MemberAddressListController extends BaseController
{
    /**
     * @param MemberAddressSearchRequest $memberAddressSearchRequest
     * @param MemberAddressService $memberAddressService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(
                             MemberAddressSearchRequest $memberAddressSearchRequest,
                             MemberAddressService $memberAddressService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $searchValue = $memberAddressSearchRequest->validated();
        $q = "";
        if(!empty($searchValue)) {
            if(isset($searchValue['q'])) {
                $q = $searchValue['q'];
            }else{
                $q = $searchValue['search']['value'] != null ? $searchValue['search']['value'] : '';
            }
        }

        $result = $this->container->call([$memberAddressService, 'get'], ['q' => $q]);

        if ($result->status) {
            $response->setData($result->memberAddressList);
            $response->setRecordsTotal($result->count);
            $response->setRecordsFiltered($result->countFiltered);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
