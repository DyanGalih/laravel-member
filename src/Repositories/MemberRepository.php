<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Content\Models\Content;
use WebAppId\Content\Models\File;
use WebAppId\Content\Models\Language;
use WebAppId\Content\Models\TimeZone;
use WebAppId\Lazy\Models\Join;
use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Repositories\Contracts\MemberRepositoryContract;
use WebAppId\User\Models\User;

/**
 * @author:
 * Date: 12:08:19
 * Time: 2020/09/16
 * Class MemberRepository
 * @package WebAppId\Member\Repositories
 */
class MemberRepository implements MemberRepositoryContract
{
    use MemberRepositoryTrait;

    public function __construct()
    {
        $this->init();
        $contents = app()->make(Join::class);
        $contents->class = File::class;
        $contents->foreign = 'files.id';
        $contents->type = 'left';
        $contents->primary = 'contents.default_image';
        $this->joinTable['files'] = $contents;
    }
}
