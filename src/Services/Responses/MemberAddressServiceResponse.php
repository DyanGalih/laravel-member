<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\Member\Models\MemberAddress;
use WebAppId\DDD\Responses\AbstractResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class MemberAddressServiceResponse extends AbstractResponse
{
    /**
     * @var MemberAddress
     */
    public $memberAddress;
}
