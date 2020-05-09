<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\MemberAddresses;

use WebAppId\Member\Services\MemberAddressService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 11:55:32
 * Time: 2020/05/09
 * Class MemberAddressDetailController
 * @package WebAppId\Member\Controllers\MemberAddresses
 */
class MemberAddressDetailController extends BaseController
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
        $result = $this->container->call([$memberAddressService, 'getById'], ['id' => $id]);

        if ($result->status) {
            $response->setData($result->memberAddress);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
