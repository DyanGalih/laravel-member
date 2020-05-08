<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Requests;

use WebAppId\DDD\Requests\AbstractFormRequest;
/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:22:16
 * Time: 2020/05/08
 * Class IdentityTypeService
 * @package WebAppId\Member\Requests
 */

class IdentityTypeSearchRequest extends AbstractFormRequest
{
    function rules():array
    {
        return [
            'q' => 'string|nullable|max:255',
            'search' => 'array|nullable|max:255',
        ];
    }
}
