<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:30
 * Time: 2020/07/19
 * Class AddressType
 * @package WebAppId\Member\Models
 */
class AddressType extends Model
{
    protected $table = 'address_types';
    protected $fillable = ['id', 'name'];
    protected $hidden = ['created_at', 'updated_at'];
}
