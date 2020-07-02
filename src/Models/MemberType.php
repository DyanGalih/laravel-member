<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 00:04:43
 * Time: 2020/07/03
 * Class MemberType
 * @package WebAppId\Member\Models
 */
class MemberType extends Model
{
    protected $table = 'member_types';
    protected $fillable = ['id', 'name'];
    protected $hidden = ['created_at', 'updated_at'];
}
