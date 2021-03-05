<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Lazy\Traits\RepositoryTrait;
use WebAppId\Member\Models\MemberAddress;
use WebAppId\Member\Repositories\Requests\MemberAddressRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 20/09/2020
 * Time: 13.04
 * Class MemberAddressRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait MemberAddressRepositoryTrait
{
    use RepositoryTrait;

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
            ->getJoin($memberAddress)
            ->when($q != null, function ($query) use ($q) {
                return $query->where(function($query) use($q){
                    return $this->getFilter($query, $q);
                });
            })
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getCount(string $identity, MemberAddress $memberAddress, string $q = null): int
    {
        return $this
            ->getJoin($memberAddress)
            ->when($q != null, function ($query) use ($q) {
                return $query->where(function($query) use($q){
                    return $this->getFilter($query, $q);
                });
            })
            ->count();
    }

    /**
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    protected function getFilter(Builder $query, string $q)
    {
        return $query->where('address', 'LIKE', '%' . $q . '%')
            ->orWhere('member_addresses.name', 'LIKE', '%' . $q . '%');
    }
}