<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Controllers\Members;

use WebAppId\Member\Requests\MemberUpdateRequest;
use WebAppId\Member\Traits\Member;
use WebAppId\Content\Repositories\TimeZoneRepository;
use WebAppId\Content\Services\Requests\ContentServiceRequest;
use WebAppId\Content\Traits\Content;
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
                             MemberUpdateRequest $memberUpdateRequest,
                             MemberServiceRequest $memberServiceRequest,
                             ContentServiceRequest $contentServiceRequest,
                             TimeZoneRepository $timeZoneRepository,
                             MemberService $memberService,
                             SmartResponse $smartResponse,
                             Response $response)
    {
        $memberValidated = $memberUpdateRequest->validated();

        $member = $this->container->call([$memberService, 'getById'], compact('id'));

        $editFormRoute = route('lazy.admin.member.show.edit', $member->member->identity);

        try {
            $memberServiceRequest = $this->transformMember($this->container, $memberValidated, $memberServiceRequest, $timeZoneRepository);
        } catch (\Exception $e) {
            report($e);
        }

        $contentServiceRequest = $this->transformContent($this->container, $memberValidated, $contentServiceRequest, $timeZoneRepository);

        $result = $this->container->call([$memberService, 'update'], compact('id', 'memberServiceRequest', 'contentServiceRequest'));

        $response->setMessage($result->message);

        if ($result->status) {
            $response->setData($result->member);
            $response->setRedirect(route('lazy.admin.member.show.index'));
            return $smartResponse->saveDataSuccess($response);
        } else {
            $response->setRedirect($editFormRoute);
            return $smartResponse->saveDataFailed($response);
        }
    }
}
