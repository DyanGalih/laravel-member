<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Member\Models\AddressType;
use WebAppId\Member\Repositories\Contracts\AddressTypeRepositoryContract;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use WebAppId\DDD\Tools\Lazy;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:31
 * Time: 2020/07/19
 * Class AddressTypeRepository
 * @package WebAppId\Member\Repositories
 */
class AddressTypeRepository implements AddressTypeRepositoryContract
{
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
     * @param AddressType $addressType
     * @param string|null $q
     * @return Builder
     */
    protected function getJoin(AddressType $addressType, string $q = null): Builder
    {
        return $addressType
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
                'address_types.id',
                'address_types.name'
            ];
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
    public function getById(int $id, AddressType $addressType): ?AddressType
    {
        return $this->getJoin($addressType)->find($id, $this->getColumn());
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
    public function get(AddressType $addressType, int $length = 12, string $q = null): LengthAwarePaginator
    {
        return $this
            ->getJoin($addressType, $q)
            ->paginate($length, $this->getColumn());
    }

    /**
     * @inheritDoc
     */
    public function getCount(AddressType $addressType, string $q = null): int
    {
        return $this
            ->getJoin($addressType, $q)
            ->count();
    }
}
