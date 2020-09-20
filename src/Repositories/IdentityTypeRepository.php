<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Member\Repositories\Contracts\IdentityTypeRepositoryContract;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeRepository
 * @package WebAppId\Member\Repositories
 */
class IdentityTypeRepository implements IdentityTypeRepositoryContract
{
    use IdentityTypeRepositoryTrait;
}
