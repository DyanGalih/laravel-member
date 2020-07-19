<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Contracts;

use WebAppId\Member\Models\AddressType;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:30
 * Time: 2020/07/19
 * Class AddressTypeRepositoryContract
 * @package WebAppId\Member\Repositories\Contracts
 */
interface AddressTypeRepositoryContract
{
    /**
     * @param AddressTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param AddressType $addressType
     * @return AddressType|null
     */
    public function store(AddressTypeRepositoryRequest $dummyRepositoryClassRequest, AddressType $addressType): ?AddressType;

    /**
     * @param int $id
     * @param AddressTypeRepositoryRequest $dummyRepositoryClassRequest
     * @param AddressType $addressType
     * @return AddressType|null
     */
    public function update(int $id, AddressTypeRepositoryRequest $dummyRepositoryClassRequest, AddressType $addressType): ?AddressType;

    /**
     * @param int $id
     * @param AddressType $addressType
     * @return AddressType|null
     */
    public function getById(int $id, AddressType $addressType): ?AddressType;

    /**
     * @param string $name
     * @param AddressType $addressType
     * @return AddressType|null
     */
    public function getByName(string $name, AddressType $addressType): ?AddressType;

    /**
     * @param int $id
     * @param AddressType $addressType
     * @return bool
     */
    public function delete(int $id, AddressType $addressType): bool;

    /**
     * @param AddressType $addressType
     * @param int $length
     * @param string $q
     * @return LengthAwarePaginator
     */
    public function get(AddressType $addressType, int $length = 12, string $q = null): LengthAwarePaginator;

    /**
     * @param AddressType $addressType
     * @return int
     * @param string $q
     */
    public function getCount(AddressType $addressType, string $q = null): int;

}
