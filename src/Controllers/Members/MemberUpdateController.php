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
use WebAppId\DDD\Controllers\BaseController;
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
    use Member, Content;

    public function __invoke(int $id,
                             MemberRequest $memberRequest,
                             MemberServiceRequest $memberServiceRequest,
                             ContentServiceRequest $contentServiceRequest,
                             TimeZoneRepository $timeZoneRepository,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberValidated = $memberRequest->validated();

        $memberServiceRequest = $this->transformMember($memberValidated, $memberServiceRequest);

        $contentServiceRequest = $this->transformContent($this->container, $memberValidated, $contentServiceRequest, $timeZoneRepository);

        $result = $this->container->call([$memberService, 'update'], compact('id', 'memberServiceRequest', 'contentServiceRequest'));

        if ($result->status) {
            $response->setData($result->member);
            return $smartResponse->saveDataSuccess($response);
        } else {
            return $smartResponse->saveDataFailed($response);
        }
    }
}
