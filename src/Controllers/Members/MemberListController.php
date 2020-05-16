<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */
namespace WebAppId\Member\Controllers\Members;

use WebAppId\Member\Requests\MemberSearchRequest;
use WebAppId\Member\Services\MemberService;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberListController
 * @package WebAppId\Member\Controllers\Members
 */
class MemberListController extends BaseController
{
    /**
     * @param MemberSearchRequest $memberSearchRequest
     * @param MemberService $memberService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     */
    public function __invoke(
                             MemberSearchRequest $memberSearchRequest,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $searchValue = $memberSearchRequest->validated();
        $q = "";
        if(!empty($searchValue)) {
            if(isset($searchValue['q'])) {
                $q = $searchValue['q'];
            }else{
                $q = $searchValue['search']['value'] != null ? $searchValue['search']['value'] : '';
            }
        }

        $result = $this->container->call([$memberService, 'get'], ['q' => $q]);

        if ($result->isStatus()) {
            $response->setData($result->memberList);
            $response->setRecordsTotal($result->count);
            $response->setRecordsFiltered($result->countFiltered);
            return $smartResponse->success($response);
        } else {
            return $smartResponse->dataNotFound($response);
        }
    }
}
