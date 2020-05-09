<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\Member\Models\Member;
use WebAppId\DDD\Responses\AbstractResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class MemberServiceResponse extends AbstractResponse
{
    /**
     * @var Member
     */
    public $member;

    /**
     * @var Collection
     */
    public $addressList;
}
