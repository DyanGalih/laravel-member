<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Seeds;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use WebAppId\Member\Repositories\MemberTypeRepository;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 04/07/2020
 * Time: 07.47
 * Class MemberTypeTableSeeder
 * @package WebAppId\Member\Seeds
 */
class MemberTypeTableSeeder extends Seeder
{
    public function run(MemberTypeRepository $memberTypeRepository)
    {
        $memberTypes = [];
        try {
            $memberTypeRepositoryRequest = app()->make(MemberTypeRepositoryRequest::class);
            $memberTypeRepositoryRequest->name = "member";
            $memberTypes[] = $memberTypeRepositoryRequest;

            foreach ($memberTypes as $memberType) {
                $memberTypeResult = app()->call([$memberTypeRepository, 'getByName'], ['name' => $memberType->name]);
                if ($memberTypeResult == null) {
                    app()->call([$memberTypeRepository, 'store'], ['memberTypeRepositoryRequest' => $memberType]);
                }
            }
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }
}
