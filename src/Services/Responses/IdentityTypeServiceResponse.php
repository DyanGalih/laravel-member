<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\DDD\Responses\AbstractResponse;
use WebAppId\Member\Models\IdentityType;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class IdentityTypeServiceResponse extends AbstractResponse
{
    /**
     * @var IdentityType
     */
    public $identityType;
}
