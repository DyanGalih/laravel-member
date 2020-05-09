<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\MemberAddresses;

use WebAppId\Member\Requests\MemberAddressRequest;
use WebAppId\Member\Services\MemberAddressService;
use WebAppId\Member\Services\Requests\MemberAddressServiceRequest;
use Illuminate\Support\Facades\Auth;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 11:55:32
 * Time: 2020/05/09
 * Class MemberAddressUpdateController
 * @package WebAppId\Member\Controllers\MemberAddresses
 */
class MemberAddressUpdateController extends BaseController
{
    public function __invoke(int $id,
                             MemberAddressRequest $memberAddressRequest,
                             MemberAddressServiceRequest $memberAddressServiceRequest,
                             MemberAddressService $memberAddressService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberAddressValidated = $memberAddressRequest->validated();

        $memberAddressServiceRequest = Lazy::copyFromArray($memberAddressValidated, $memberAddressServiceRequest, Lazy::AUTOCAST);

        $memberAddressServiceRequest->user_id = Auth::user()->id;
        $memberAddressServiceRequest->creator_id = Auth::user()->id;
        $memberAddressServiceRequest->owner_id = Auth::user()->id;
            
        $result = $this->container->call([$memberAddressService, 'update'], ['id' => $id, 'memberAddressServiceRequest' => $memberAddressServiceRequest]);

        if ($result->status) {
            $response->setData($result->memberAddress);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
