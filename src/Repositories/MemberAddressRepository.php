<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Lazy\Models\Join;
use WebAppId\Member\Models\AddressType;
use WebAppId\Member\Models\Member;
use WebAppId\Member\Repositories\Contracts\MemberAddressRepositoryContract;
use WebAppId\User\Models\User;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressRepository
 * @package WebAppId\Member\Repositories
 */
class MemberAddressRepository implements MemberAddressRepositoryContract
{
    use MemberAddressRepositoryTrait;

    public function __construct()
    {
        $user = app()->make(Join::class);
        $user->class = User::class;
        $user->foreign = 'creator_id';
        $this->joinTable['users'] = $user;

        $owner_user = app()->make(Join::class);
        $owner_user->class = User::class;
        $owner_user->foreign = 'owner_id';
        $this->joinTable['owner_users'] = $owner_user;

        $user_user = app()->make(Join::class);
        $user_user->class = User::class;
        $user_user->foreign = 'user_id';
        $this->joinTable['user_users'] = $user_user;

        $address_type = app()->make(Join::class);
        $address_type->class = AddressType::class;
        $address_type->foreign = 'type_id';
        $this->joinTable['address_types'] = $address_type;

        $member = app()->make(Join::class);
        $member->class = Member::class;
        $member->foreign = 'member_id';
        $this->joinTable['members'] = $member;
    }
}
