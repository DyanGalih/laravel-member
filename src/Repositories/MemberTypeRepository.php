<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Models\MemberType;
use WebAppId\Member\Repositories\Contracts\MemberTypeRepositoryContract;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeRepository
 * @package WebAppId\Member\Repositories
 */
class MemberTypeRepository implements MemberTypeRepositoryContract
{
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
     * @param MemberType $memberType
     * @param string|null $q
     * @return Builder
     */
    protected function getJoin(MemberType $memberType, string $q = null): Builder
    {
        return $memberType
            ->when($q != null, function ($query) use ($q) {
                return $query->where('name', 'LIKE', '%' . $q . '%');
            });
    }

    /**
     * @return array
     */
    protected function getColumn(): array
    {
        return
            [
                'member_types.id',
                'member_types.name',
                'member_types.created_at',
                'member_types.updated_at'
            ];
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

    /**
     * @inheritDoc
     */
    public function get(MemberType $memberType, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($memberType, $q)
            ->paginate($length, $this->getColumn())
            ->appends(request()->input());
    }

    /**
     * @inheritDoc
     */
    public function getCount(MemberType $memberType, string $q = null): int
    {
        return $this
            ->getJoin($memberType, $q)
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
