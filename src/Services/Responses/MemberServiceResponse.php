<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Services\Responses;

use WebAppId\Content\Models\Content;
use WebAppId\DDD\Responses\AbstractResponse;
use WebAppId\Member\Models\Member;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
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
     * @var Content
     */
    public $content;

    /**
     * @var array
     */
    public $galleries = [];

    /**
     * @var array
     */
    public $categories = [];

    /**
     * @var array
     */
    public $children=[];
}
