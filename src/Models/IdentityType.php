<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityType
 * @package WebAppId\Member\Models
 */
class IdentityType extends Model
{
    protected $table = 'identity_types';
    protected $fillable = ['id', 'name', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
