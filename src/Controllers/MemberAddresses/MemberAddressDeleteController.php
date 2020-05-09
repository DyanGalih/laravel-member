<?php
/**
* Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
*/
namespace WebAppId\Member\Controllers\MemberAddresses;

use WebAppId\Member\Requests\MemberAddressRequest;
use WebAppId\Member\Services\MemberAddressService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 11:55:32
 * Time: 2020/05/09
 * Class MemberAddressDeleteController
 * @package WebAppId\Member\Controllers\MemberAddresses
 */
class MemberAddressDeleteController extends BaseController
{
    /**
     * @param int $id
     * @param MemberAddressService $memberAddressService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(int $id,
                             MemberAddressService $memberAddressService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $result = $this->container->call([$memberAddressService, 'delete'], ['id' => $id]);

        if ($result) {
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
