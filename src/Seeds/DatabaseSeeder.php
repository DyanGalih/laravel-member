<?php

namespace WebAppId\Member\Seeds;

use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * UserParam: dyangalih
 * Date: 2019-01-25
 * Time: 11:55
 */
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(ContentCategoryTableSeeder::class);
        $this->call(MemberTypeTableSeeder::class);
        $this->call(IdentityTypeTableSeeder::class);
        $this->call(AddressTypeTableSeeder::class);
    }
}
