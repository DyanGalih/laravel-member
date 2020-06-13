<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Member\Models\IdentityType;
use WebAppId\Member\Repositories\Contracts\IdentityTypeRepositoryContract;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeRepository
 * @package WebAppId\Member\Repositories
 */
class IdentityTypeRepository implements IdentityTypeRepositoryContract
{
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
     * @param IdentityType $identityType
     * @param string|null $q
     * @return Builder
     */
    public function getJoin(IdentityType $identityType, string $q = null): Builder
    {
        return $identityType
            ->join('users as users', 'identity_types.user_id', 'users.id')
            ->when($q != null, function ($query) use ($q) {
                return $query->where('identity_types.name', 'LIKE', '%' . $q . '%');
            });
    }

    /**
     * @return array
     */
    protected function getColumn(): array
    {
        return [
            'identity_types.id',
            'identity_types.name',
            'identity_types.user_id',
            'users.name AS user_name',
        ];
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
            ->getJoin($identityType, $q)
            ->paginate($length, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getCount(IdentityType $identityType, string $q = null): int
    {
        return $this
            ->getJoin($identityType, $q)
            ->count();
    }
}
