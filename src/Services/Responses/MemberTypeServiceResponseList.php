<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Responses\AbstractResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeServiceResponseList
 * @package WebAppId\Member\Services\Responses
 */
class MemberTypeServiceResponseList extends AbstractResponseList
{
    /**
     * @var LengthAwarePaginator
     */
    public $memberTypeList;
}
