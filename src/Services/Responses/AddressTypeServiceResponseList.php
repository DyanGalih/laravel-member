<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Responses\AbstractResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeServiceResponseList
 * @package WebAppId\Member\Services\Responses
 */
class AddressTypeServiceResponseList extends AbstractResponseList
{
    /**
     * @var LengthAwarePaginator
     */
    public $addressTypeList;
}
