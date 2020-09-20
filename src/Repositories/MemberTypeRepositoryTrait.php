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
use WebAppId\Member\Models\MemberType;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 20/09/2020
 * Time: 12.42
 * Class MemberTypeRepositoryTrait
 * @package WebAppId\Member\Repositories
 */
trait MemberTypeRepositoryTrait
{
    use RepositoryTrait;

    /**
     * @inheritDoc
     */
    public function store(MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberType $memberType): ?MemberType
    {
        try {
            $memberType = Lazy::copy($memberTypeRepositoryRequest, $memberType);
            $memberType->save();
            return $memberType;
        } catch (QueryException $queryException) {
            report($queryException);
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, MemberTypeRepositoryRequest $memberTypeRepositoryRequest, MemberType $memberType): ?MemberType
    {
        $memberType = $this->getById($id, $memberType);
        if ($memberType != null) {
            try {
                $memberType = Lazy::copy($memberTypeRepositoryRequest, $memberType);
                $memberType->save();
                return $memberType;
            } catch (QueryException $queryException) {
                report($queryException);
            }
        }
        return $memberType;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, MemberType $memberType): ?MemberType
    {
        return $this->getJoin($memberType)->find($id, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id, MemberType $memberType): bool
    {
        $memberType = $this->getById($id, $memberType);
        if ($memberType != null) {
            return $memberType->delete();
        } else {
            return false;
        }
    }

    protected function getFilter(Builder $builder, string $q = null)
    {
        return $builder->where('name', 'LIKE', '%' . $q . '%');

    }

    /**
     * @inheritDoc
     */
    public function get(MemberType $memberType, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($memberType)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getCount(MemberType $memberType, string $q = null): int
    {
        return $this
            ->getJoin($memberType)
            ->when($q != null, function ($query) use ($q) {
                return $this->getFilter($query, $q);
            })
            ->count();
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name, MemberType $memberType): ?MemberType
    {
        return $this->getJoin($memberType)->where('name', $name)->first($this->getColumn());
    }
}