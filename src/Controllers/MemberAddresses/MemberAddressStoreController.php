<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Controllers\MemberAddresses;

use WebAppId\Content\Traits\Content;
use WebAppId\Member\Requests\MemberAddressRequest;
use WebAppId\Member\Services\MemberAddressService;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use Exception;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 11:55:32
 * Time: 2020/05/09
 * Class MemberAddressStoreController
 * @package WebAppId\Member\Controllers\MemberAddresses
 */
class MemberAddressStoreController extends BaseController
{

    use Content;

    /**
     * @param MemberAddressRequest $memberAddressRequest
     * @param MemberAddressServiceRequest $memberAddressServiceRequest
     * @param MemberAddressService $memberAddressService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     * @throws Exception
     */
    public function __invoke(MemberAddressRequest $memberAddressRequest,
                             MemberAddressServiceRequest $memberAddressServiceRequest,
                             MemberAddressService $memberAddressService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberAddressValidated = $memberAddressRequest->validated();

        $memberAddressServiceRequest = Lazy::copyFromArray($memberAddressValidated, $memberAddressServiceRequest, Lazy::AUTOCAST);

        $result = $this->container->call([$memberAddressService, 'store'], compact('memberAddressServiceRequest'));

        if ($result->status) {
            $response->setData($result->memberAddress);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
