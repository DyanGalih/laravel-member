<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use Illuminate\Database\Eloquent\Collection;
use WebAppId\Content\Services\Responses\ContentServiceResponse;
use WebAppId\Member\Models\Member;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberServiceResponse
 * @package WebAppId\Member\Services\Responses
 */
class MemberServiceResponse extends ContentServiceResponse
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
