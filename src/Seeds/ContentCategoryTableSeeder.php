<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Seeds;


use Illuminate\Database\Seeder;
use WebAppId\Content\Repositories\CategoryRepository;
use WebAppId\Content\Repositories\Requests\CategoryRepositoryRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 19/05/2020
 * Time: 08.16
 * Class ContentCategoryTableSeeder
 * @package WebAppId\Member\Seeds
 */
class ContentCategoryTableSeeder extends Seeder
{
    public function run(CategoryRepository $categoryRepository)
    {
        $categoryRepositoryRequest = $this->container->make(CategoryRepositoryRequest::class);
        $categoryRepositoryRequest->code = 'profile';
        $categoryRepositoryRequest->name = 'Profile';
        $categoryRepositoryRequest->user_id = '1';
        $categoryRepositoryRequest->status_id = '1';
        $categoryRepositoryRequest->parent_id = '0';

        $category = $this->container->call([$categoryRepository, 'getByName'], ['name' => $categoryRepositoryRequest->name]);
        if ($category == null) {
            $this->container->call([$categoryRepository, 'store'], compact('categoryRepositoryRequest'));
        }
    }
}