<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Models;

use Illuminate\Database\Eloquent\Model;
use WebAppId\Content\Models\Content;
use WebAppId\Lazy\Traits\ModelTrait;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class Member
 * @package WebAppId\Member\Models
 */
class Member extends Model
{
    use ModelTrait;
    
    protected $table = 'members';
    protected $fillable = ['id', 'identity_type_id', 'name', 'identity', 'email', 'phone', 'phone_alternative', 'sex', 'dob', 'timezone_id', 'language_id', 'content_id'];
    protected $hidden = ['user_id', 'creator_id', 'owner_id', 'created_at', 'updated_at'];

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
    
    public function addresses()
    {
        return $this->hasMany(MemberAddress::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

}
