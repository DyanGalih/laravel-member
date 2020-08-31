<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Models\MemberAddress;
use WebAppId\Member\Repositories\Contracts\MemberAddressRepositoryContract;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressRepository
 * @package WebAppId\Member\Repositories
 */
class MemberAddressRepository implements MemberAddressRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function store(MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddress $memberAddress): ?MemberAddress
    {
        try {
            $memberAddress = Lazy::copy($memberAddressRepositoryRequest, $memberAddress);
            $memberAddress->save();
            return $memberAddress;
        } catch (QueryException $queryException) {
            report($queryException);
            return null;
        }
    }

    /**
     * @param MemberAddress $memberAddress
     * @param string|null $q
     * @return Builder
     */
    public function getJoin(MemberAddress $memberAddress, string $q = null): Builder
    {
        return $memberAddress
            ->join('users as users', 'member_addresses.creator_id', 'users.id')
            ->join('address_types as address_types', 'member_addresses.type_id', 'address_types.id')
            ->join('members as members', 'member_addresses.member_id', 'members.id')
            ->join('users as owner_users', 'member_addresses.owner_id', 'owner_users.id')
            ->join('users as user_users', 'member_addresses.user_id', 'user_users.id')
            ->when($q != null, function ($query) use ($q) {
                return $query->where('address', 'LIKE', '%' . $q . '%')
                    ->orWhere('member_addresses.name', 'LIKE', '%' . $q . '%');
            });
    }

    /**
     * @return array
     */
    protected function getColumn(): array
    {
        return [
            'member_addresses.id',
            'address_types.name AS address_type',
            'member_addresses.code',
            'member_addresses.name',
            'member_addresses.member_id',
            'member_addresses.address',
            'member_addresses.city',
            'member_addresses.state',
            'member_addresses.post_code',
            'member_addresses.country',
            'member_addresses.isDefault',
            'member_addresses.user_id',
            'member_addresses.creator_id',
            'member_addresses.owner_id',
            'member_addresses.created_at',
            'member_addresses.updated_at',
            'users.name AS creator_name',
            'users.email AS creator_email',
            'members.identity',
            'members.code AS member_code',
            'members.name AS member_name',
            'members.email',
            'members.phone',
            'owner_users.id AS owner_id',
            'owner_users.name AS owner_name',
            'owner_users.email AS owner_email',
            'user_users.id AS user_id',
            'user_users.name AS user_name',
            'user_users.email AS user_email'
        ];
    }

    /**
     * @inheritDoc
     */
    public function update(string $code, MemberAddressRepositoryRequest $memberAddressRepositoryRequest, MemberAddress $memberAddress): ?MemberAddress
    {
        $memberAddress = $memberAddress->where('code', $code)->first();
        if ($memberAddress != null) {
            try {
                $memberAddress = Lazy::copy($memberAddressRepositoryRequest, $memberAddress);
                $memberAddress->save();
                return $memberAddress;
            } catch (QueryException $queryException) {
                report($queryException);
            }
        }
        return $memberAddress;
    }

    /**
     * @inheritDoc
     */
    public function getByCode(string $code, MemberAddress $memberAddress): ?MemberAddress
    {
        return $this->getJoin($memberAddress)->where('member_addresses.code', $code)->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function delete(string $code, MemberAddress $memberAddress): bool
    {
        $memberAddress = $memberAddress->where('code', $code)->first();
        if ($memberAddress != null) {
            return $memberAddress->delete();
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $identity, MemberAddress $memberAddress, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($memberAddress, $q)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getCount(string $identity, MemberAddress $memberAddress, string $q = null): int
    {
        return $this
            ->getJoin($memberAddress, $q)
            ->count();
    }
}
