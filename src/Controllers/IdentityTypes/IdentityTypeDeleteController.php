<?php
/**
* Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
*/
namespace WebAppId\Member\Controllers\IdentityTypes;

use WebAppId\Member\Requests\IdentityTypeRequest;
use WebAppId\Member\Services\IdentityTypeService;
use WebAppId\Member\Services\Requests\IdentityTypeServiceRequest;
use Exception;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeDeleteController
 * @package WebAppId\Member\Controllers\IdentityTypes
 */
class IdentityTypeDeleteController extends BaseController
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
        $result = $this->container->call([$identityTypeService, 'delete'], ['id' => $id]);

        if ($result) {
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
