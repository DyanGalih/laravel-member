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
 * Class MemberDetailController
 * @package WebAppId\Member\Controllers\Members
 */
class MemberDetailController extends BaseController
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
        $result = $this->container->call([$memberService, 'getById'], ['id' => $id]);

        if ($result->status) {
            $response->setData($result->member);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
