<?php
/**
* Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
*/
namespace WebAppId\Member\Controllers\IdentityTypes;

use WebAppId\Member\Requests\IdentityTypeRequest;
use WebAppId\Member\Services\IdentityTypeService;
use WebAppId\Member\Services\Requests\IdentityTypeServiceRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeStoreController
 * @package WebAppId\Member\Controllers\IdentityTypes
 */
class IdentityTypeStoreController extends BaseController
{
    /**
     * @param IdentityTypeRequest $identityTypeRequest
     * @param IdentityTypeServiceRequest $identityTypeServiceRequest
     * @param IdentityTypeService $identityTypeService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     * @throws Exception
     */
    public function __invoke(IdentityTypeRequest $identityTypeRequest,
                             IdentityTypeServiceRequest $identityTypeServiceRequest,
                             IdentityTypeService $identityTypeService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $identityTypeValidated = $identityTypeRequest->validated();

        $identityTypeServiceRequest = Lazy::copyFromArray($identityTypeValidated, $identityTypeServiceRequest, Lazy::AUTOCAST);

        $identityTypeServiceRequest->user_id = Auth::user()->id;
            
        $result = $this->container->call([$identityTypeService, 'store'], ['identityTypeServiceRequest' => $identityTypeServiceRequest]);

        if ($result->isStatus()) {
            $response->setData($result->identityType);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
