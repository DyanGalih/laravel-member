<?php
/**
 * Created by PhpStorm.
 */

use Illuminate\Support\Facades\Auth;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Services\Requests\MemberServiceRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 09/05/2020
 * Time: 16.15
 * Class Member
 * @package ${NAMESPACE}
 */
trait Member
{
    /**
     * @param array $memberValidated
     * @param MemberServiceRequest $memberServiceRequest
     * @return MemberServiceRequest
     */
    public function transformMember(array $memberValidated, MemberServiceRequest $memberServiceRequest): MemberServiceRequest
    {
        $memberServiceRequest = Lazy::copyFromArray($memberValidated, $memberServiceRequest, Lazy::AUTOCAST);
        $memberServiceRequest->user_id = Auth::id();
        $memberServiceRequest->creator_id = Auth::id();
        $memberServiceRequest->owner_id = Auth::id();
        return $memberServiceRequest;
    }
}