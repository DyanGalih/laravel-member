<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Seeds;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use WebAppId\Member\Repositories\AddressTypeRepository;
use WebAppId\Member\Repositories\Requests\AddressTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 04/07/2020
 * Time: 07.47
 * Class MemberTypeTableSeeder
 * @package WebAppId\Member\Seeds
 */
class AddressTypeTableSeeder extends Seeder
{
    public function run(AddressTypeRepository $addressTypeRepository)
    {
        $memberTypes = [];
        try {
            $addressTypeRepositoryRequest = app()->make(AddressTypeRepositoryRequest::class);
            $addressTypeRepositoryRequest->name = "home";
            $memberTypes[] = $addressTypeRepositoryRequest;

            foreach ($memberTypes as $memberType) {
                $memberTypeResult = app()->call([$addressTypeRepository, 'getByName'], ['name' => $memberType->name]);
                if ($memberTypeResult == null) {
                    app()->call([$addressTypeRepository, 'store'], ['addressTypeRepositoryRequest' => $memberType]);
                }
            }
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }
}
