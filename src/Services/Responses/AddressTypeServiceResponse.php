<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\DDD\Responses\AbstractResponse;
use WebAppId\Member\Models\AddressType;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class AddressTypeServiceResponse extends AbstractResponse
{
    /**
     * @var AddressType
     */
    public $addressType;
}
