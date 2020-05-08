<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Responses\AbstractResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeServiceResponseList
 * @package WebAppId\Member\Services\Responses
 */
class IdentityTypeServiceResponseList extends AbstractResponseList
{
    /**
     * @var LengthAwarePaginator
     */
    public $identityTypeList;
}
