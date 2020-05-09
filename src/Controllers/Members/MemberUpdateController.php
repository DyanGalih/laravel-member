<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\Members;

use WebAppId\Member\Requests\MemberRequest;
use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use Illuminate\Support\Facades\Auth;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:52
 * Time: 2020/05/09
 * Class MemberUpdateController
 * @package WebAppId\Member\Controllers\Members
 */
class MemberUpdateController extends BaseController
{
    public function __invoke(int $id,
                             MemberRequest $memberRequest,
                             MemberServiceRequest $memberServiceRequest,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberValidated = $memberRequest->validated();

        $memberServiceRequest = Lazy::copyFromArray($memberValidated, $memberServiceRequest, Lazy::AUTOCAST);

        $memberServiceRequest->user_id = Auth::user()->id;
        $memberServiceRequest->creator_id = Auth::user()->id;
        $memberServiceRequest->owner_id = Auth::user()->id;
            
        $result = $this->container->call([$memberService, 'update'], ['id' => $id, 'memberServiceRequest' => $memberServiceRequest]);

        if ($result->isStatus()) {
            $response->setData($result->member);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
