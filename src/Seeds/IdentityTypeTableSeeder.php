<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Seeds;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use WebAppId\DDD\Tools\Lazy;
use WebAppId\Member\Repositories\IdentityTypeRepository;
use WebAppId\Member\Repositories\Requests\IdentityTypeRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 17/05/2020
 * Time: 10.21
 * Class IdentityTypeTableSeeder
 * @package WebAppId\Member\Seeds
 */
class IdentityTypeTableSeeder extends Seeder
{
    /**
     * @param IdentityTypeRepository $identityTypeRepository
     * @throws BindingResolutionException
     */
    public function run(IdentityTypeRepository $identityTypeRepository): void
    {
        $identityTypes =
            [
                [
                    "name" => "member",
                    "user_id" => 1
                ]
            ];

        $identityTypeRepositoryRequest = $this->container->make(IdentityTypeRepositoryRequest::class);

        foreach ($identityTypes as $identityType) {
            $identityTypeRepositoryRequest = Lazy::copyFromArray($identityType, $identityTypeRepositoryRequest, Lazy::AUTOCAST);
            $result = $this->container->call([$identityTypeRepository, 'getByName'], ['name' => $identityTypeRepositoryRequest->name]);
            if($result == null){
                $this->container->call([$identityTypeRepository, 'store'],compact('identityTypeRepositoryRequest'));
            }
        }
    }
}
