<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\Member\Models\IdentityType;
use WebAppId\DDD\Responses\AbstractResponse;

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
