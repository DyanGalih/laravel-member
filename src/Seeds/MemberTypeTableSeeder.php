<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Seeds;

use WebAppId\Member\Repositories\MemberTypeRepository;
use WebAppId\Member\Repositories\Requests\MemberTypeRepositoryRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 04/07/2020
 * Time: 07.47
 * Class MemberTypeTableSeeder
 * @package ${NAMESPACE}
 */
class MemberTypeTableSeeder extends Seeder
{
    public function run(MemberTypeRepository $memberTypeRepository)
    {
        $memberTypes = [];
        try {
            $memberTypeRepositoryRequest = $this->container->make(MemberTypeRepositoryRequest::class);
            $memberTypeRepositoryRequest->name = "member";
            $memberTypes[] = $memberTypeRepositoryRequest;

            foreach ($memberTypes as $memberType) {
                $memberTypeResult = $this->container->call([$memberTypeRepository, 'getByName'], ['name' => $memberType->name]);
                if ($memberTypeResult == null) {
                    $this->container->call([$memberTypeRepository, 'store'], ['memberTypeRepositoryRequest' => $memberType]);
                }
            }
        } catch (BindingResolutionException $e) {
            report($e);
        }

    }
}
