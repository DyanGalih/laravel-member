<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;
use WebAppId\Lazy\Traits\ModelTrait;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 13:56:30
 * Time: 2020/07/19
 * Class AddressType
 * @package WebAppId\Member\Models
 */
class AddressType extends Model
{
    use ModelTrait;
    
    protected $table = 'address_types';
    protected $fillable = ['id', 'name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getColumns(bool $isFresh = false)
    {
        $columns = $this->getAllColumn($isFresh);

        $forbiddenField = [
            "created_at",
            "updated_at"
        ];
        foreach ($forbiddenField as $item) {
            unset($columns[$item]);
        }

        return $columns;
    }
}
