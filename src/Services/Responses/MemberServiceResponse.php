<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\DDD\Responses\AbstractResponse;
use WebAppId\Member\Models\Member;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
 * Class MemberServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class MemberServiceResponse extends AbstractResponse
{
    /**
     * @var Member
     */
    public $member;
}
