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
use WebAppId\Member\Models\AddressType;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 20/09/2020
 * Time: 13.01
 * Class AddressTypeRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait AddressTypeRepositoryTrait
{
    use RepositoryTrait;

    /**
     * @inheritDoc
     */
    public function store(AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressType $addressType): ?AddressType
    {
        try {
            $addressType = Lazy::copy($addressTypeRepositoryRequest, $addressType);
            $addressType->save();
            return $addressType;
        } catch (QueryException $queryException) {
            report($queryException);
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, AddressTypeRepositoryRequest $addressTypeRepositoryRequest, AddressType $addressType): ?AddressType
    {
        $addressType = $addressType->find($id);
        if ($addressType != null) {
            try {
                $addressType = Lazy::copy($addressTypeRepositoryRequest, $addressType);
                $addressType->save();
                return $addressType;
            } catch (QueryException $queryException) {
                report($queryException);
            }
        }
        return $addressType;
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, AddressType $addressType): ?AddressType
    {
        return $this->getJoin($addressType)->where('name', $name)->first();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, AddressType $addressType): bool
    {
        $addressType = $this->getById($id, $addressType);
        if ($addressType != null) {
            return $addressType->delete();
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, AddressType $addressType): ?AddressType
    {
        return $this->getJoin($addressType)->find($id, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function get(AddressType $addressType, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($addressType)
            ->when($q != null, function ($query) use ($q) {
                return $query->where(function($query) use($q){
                    return $this->getFilter($query, $q);
                });
            })
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    protected function getFilter(Builder $query, string $q): Builder
    {
        return $query->where('name', 'LIKE', '%' . $q . '%');
    }

    /**
     * @inheritDoc
     */
    public function getCount(AddressType $addressType, string $q = null): int
    {
        return $this
            ->getJoin($addressType)
            ->when($q != null, function ($query) use ($q) {
                return $query->where(function($query) use($q){
                    return $this->getFilter($query, $q);
                });
            })
            ->count();
    }
}