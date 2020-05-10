<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\IdentityTypes;

use WebAppId\Member\Requests\IdentityTypeRequest;
use WebAppId\Member\Services\IdentityTypeService;
use WebAppId\Member\Services\Requests\IdentityTypeServiceRequest;
use Illuminate\Support\Facades\Auth;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeUpdateController
 * @package WebAppId\Member\Controllers\IdentityTypes
 */
class IdentityTypeUpdateController extends BaseController
{
    public function __invoke(int $id,
                             IdentityTypeRequest $identityTypeRequest,
                             IdentityTypeServiceRequest $identityTypeServiceRequest,
                             IdentityTypeService $identityTypeService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $identityTypeValidated = $identityTypeRequest->validated();

        $identityTypeServiceRequest = Lazy::copyFromArray($identityTypeValidated, $identityTypeServiceRequest, Lazy::AUTOCAST);

        $identityTypeServiceRequest->user_id = Auth::id();
            
        $result = $this->container->call([$identityTypeService, 'update'], ['id' => $id, 'identityTypeServiceRequest' => $identityTypeServiceRequest]);

        if ($result->isStatus()) {
            $response->setData($result->identityType);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
