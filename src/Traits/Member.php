<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Traits;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use WebAppId\Content\Repositories\TimeZoneRepository;
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
     * @throws \Exception
     */
    public function transformMember(Container $container,
                                    array $memberValidated,
                                    MemberServiceRequest $memberServiceRequest,
                                    TimeZoneRepository $timeZoneRepository): MemberServiceRequest
    {
        if (session('timezone') == null) {
            $zone = "Asia/Jakarta";
        } else {
            $zone = session('timezone');
        }

        $timeZoneData = $container->call([$timeZoneRepository, 'getByName'], ['name' => $zone]);
        $memberValidated['dob'] = isset($memberValidated['dob']) ? $memberValidated['dob'] : '1928-01-01';
        $memberValidated['language_id'] = isset($memberValidated['language_id']) ? $memberValidated['language_id'] : 1;
        $memberValidated['timezone_id'] = isset($timeZoneData) ? $timeZoneData->id : 271;
        $memberServiceRequest = Lazy::copyFromArray($memberValidated, $memberServiceRequest, Lazy::AUTOCAST);
        $memberServiceRequest->user_id = Auth::id();
        $memberServiceRequest->creator_id = Auth::id();
        $memberServiceRequest->owner_id = Auth::id();
        return $memberServiceRequest;
    }
}
