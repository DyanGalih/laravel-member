<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\DDD\Responses\AbstractResponse;
use WebAppId\Member\Models\MemberType;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class MemberTypeServiceResponse extends AbstractResponse
{
    /**
     * @var MemberType
     */
    public $memberType;
}
