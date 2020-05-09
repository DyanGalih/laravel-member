<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Responses\AbstractResponseList;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceResponseList
 * @package WebAppId\Member\Services\Responses
 */
class MemberServiceResponseList extends AbstractResponseList
{
    /**
     * @var LengthAwarePaginator
     */
    public $memberList;
}
