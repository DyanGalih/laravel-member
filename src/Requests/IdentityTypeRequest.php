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

class IdentityTypeRequest extends AbstractFormRequest
{
    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [
            'name' => 'string|required|max:50'
         ];
    }
}
