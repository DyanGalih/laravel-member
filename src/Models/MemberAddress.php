<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddress
 * @package WebAppId\Member\Models
 */
class MemberAddress extends Model
{
    protected $table = 'member_addresses';
    protected $fillable = ['id', 'code', 'name', 'member_id', 'address', 'city', 'state', 'post_code', 'country', 'isDefault'];
    protected $hidden = ['user_id', 'creator_id', 'owner_id', 'created_at', 'updated_at'];
}
