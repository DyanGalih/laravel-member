<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories;

use WebAppId\Member\Repositories\Contracts\MemberTypeRepositoryContract;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberTypeRepository
 * @package WebAppId\Member\Repositories
 */
class MemberTypeRepository implements MemberTypeRepositoryContract
{
    use MemberTypeRepositoryTrait;
}
