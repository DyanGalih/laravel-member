<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Requests;

use WebAppId\DDD\Requests\AbstractFormRequest;
/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberService
 * @package WebAppId\Member\Requests
 */

class MemberRequest extends AbstractFormRequest
{
    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [
            'identity_type_id' => 'int|required',
            'identity' => 'string|required|max:255',
            'email' => 'string|required|max:100',
            'phone' => 'string|required|max:20',
            'phone_alternative' => 'string|required|max:255',
            'sex' => 'string|required|max:1',
            'dob' => 'string|required',
            'timezone_id' => 'int|required',
            'language_id' => 'int|required',
            'picture_id' => 'int|required'
         ];
    }
}
