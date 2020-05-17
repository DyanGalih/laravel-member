<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\IdentityTypes;

use WebAppId\Member\Services\IdentityTypeService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeDetailController
 * @package WebAppId\Member\Controllers\IdentityTypes
 */
class IdentityTypeDetailController extends BaseController
{
    /**
     * @param int $id
     * @param IdentityTypeService $identityTypeService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(int $id,
                             IdentityTypeService $identityTypeService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $result = $this->container->call([$identityTypeService, 'getById'], ['id' => $id]);

        if ($result->status) {
            $response->setData($result->identityType);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
