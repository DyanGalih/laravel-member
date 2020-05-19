<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Controllers\Members;

use WebAppId\Member\Traits\Member;
use WebAppId\Content\Repositories\TimeZoneRepository;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Content\Traits\Content;
use WebAppId\Member\Requests\MemberRequest;
use WebAppId\Member\Services\MemberService;
use WebAppId\Member\Services\Requests\MemberServiceRequest;
use Exception;
use WebAppId\DDD\Controllers\BaseController;
use WebAppId\SmartResponse\Response;
use WebAppId\SmartResponse\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberStoreController
 * @package WebAppId\Member\Controllers\Members
 */
class MemberStoreController extends BaseController
{
    use Content, Member;

    /**
     * @param MemberRequest $memberRequest
     * @param ContentServiceRequest $contentServiceRequest
     * @param TimeZoneRepository $timeZoneRepository
     * @param MemberServiceRequest $memberServiceRequest
     * @param MemberService $memberService
     * @param SmartResponse $smartResponse
     * @param Response $response
     * @return mixed
     * @throws Exception
     */
    public function __invoke(MemberRequest $memberRequest,
                             ContentServiceRequest $contentServiceRequest,
                             TimeZoneRepository $timeZoneRepository,
                             MemberServiceRequest $memberServiceRequest,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberValidated = $memberRequest->validated();

        $memberServiceRequest = $this->transformMember($this->container, $memberValidated, $memberServiceRequest, $timeZoneRepository);

        $memberValidated['title'] = isset($memberValidated['title']) ? $memberValidated['title'] : $memberValidated['name'];

        $contentServiceRequest = $this->transformContent($this->container, $memberValidated, $contentServiceRequest, $timeZoneRepository);

        $result = $this->container->call([$memberService, 'store'], compact('memberServiceRequest', 'contentServiceRequest'));

        if ($result->status) {
            $response->setData($result->member);
            $response->setRedirect(route('lazy.admin.member.show.index'));
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
