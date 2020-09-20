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
use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 20/09/2020
 * Time: 12.58
 * Class IdentityTypeRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait IdentityTypeRepositoryTrait
{
    use RepositoryTrait;

    /**
     * @inheritDoc
     */
    public function store(IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityType $identityType): ?IdentityType
    {
        try {
            $identityType = Lazy::copy($identityTypeRepositoryRequest, $identityType);
            $identityType->save();
            return $identityType;
        } catch (QueryException $queryException) {
            report($queryException);
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, IdentityTypeRepositoryRequest $identityTypeRepositoryRequest, IdentityType $identityType): ?IdentityType
    {
        $identityType = $identityType->find($id);
        if ($identityType != null) {
            try {
                $identityType = Lazy::copy($identityTypeRepositoryRequest, $identityType);
                $identityType->save();
                return $identityType;
            } catch (QueryException $queryException) {
                report($queryException);
            }
        }
        return $identityType;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, IdentityType $identityType): ?IdentityType
    {
        return $this->getJoin($identityType)->find($id, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, IdentityType $identityType): ?IdentityType
    {
        return $this->getJoin($identityType)->where('identity_types.name', $name)->first($this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, IdentityType $identityType): bool
    {
        $identityType = $identityType->find($id);
        if ($identityType != null) {
            return $identityType->delete();
        } else {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function get(IdentityType $identityType, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($identityType)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @param Builder $query
     * @param string $q
     * @return Builder
     */
    protected function getFilter(Builder $query, string $q)
    {
        return $query->where('identity_types.name', 'LIKE', '%' . $q . '%');
    }

    /**
     * @inheritDoc
     */
    public function getCount(IdentityType $identityType, string $q = null): int
    {
        return $this
            ->getJoin($identityType)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->count();
    }
}