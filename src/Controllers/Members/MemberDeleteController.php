<?php
/**
* Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
*/
namespace WebAppId\Member\Controllers\Members;

use WebAppId\Member\Services\MemberService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberDeleteController
 * @package WebAppId\Member\Controllers\Members
 */
class MemberDeleteController extends BaseController
{
    /**
     * @param int $id
     * @param MemberService $memberService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(int $id,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $result = $this->container->call([$memberService, 'delete'], ['id' => $id]);

        if ($result) {
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
