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
        $content = app()->make(Join::class);
        $content->class = Content::class;
        $content->foreign = 'content_id';
        $this->joinTable['contents'] = $content;

        $time_zone = app()->make(Join::class);
        $time_zone->class = TimeZone::class;
        $time_zone->foreign = 'timezone_id';
        $this->joinTable['time_zones'] = $time_zone;

        $user = app()->make(Join::class);
        $user->class = User::class;
        $user->foreign = 'creator_id';
        $this->joinTable['users'] = $user;

        $owner_users = app()->make(Join::class);
        $owner_users->class = User::class;
        $owner_users->foreign = 'owner_id';
        $this->joinTable['owner_users'] = $owner_users;

        $user_users = app()->make(Join::class);
        $user_users->class = User::class;
        $user_users->foreign = 'user_id';
        $this->joinTable['user_users'] = $user_users;

        $files = app()->make(Join::class);
        $files->class = File::class;
        $files->foreign = 'contents.default_image';
        $files->type = 'left';
        $this->joinTable['files'] = $files;

        $identity_types = app()->make(Join::class);
        $identity_types->class = IdentityType::class;
        $identity_types->foreign = 'identity_type_id';
        $identity_types->type = 'left';
        $this->joinTable['identity_types'] = $identity_types;

        $languages = app()->make(Join::class);
        $languages->class = Language::class;
        $languages->foreign = 'language_id';
        $this->joinTable['languages'] = $languages;

        $profile_users = app()->make(Join::class);
        $profile_users->class = User::class;
        $profile_users->foreign = 'profile_id';
        $profile_users->type = 'left';
        $this->joinTable['profile_users'] = $profile_users;

    }
}
