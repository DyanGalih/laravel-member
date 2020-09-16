<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Responses\AbstractResponseList;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
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
