<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Requests;

use WebAppId\DDD\Requests\AbstractFormRequest;
/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressService
 * @package WebAppId\Member\Requests
 */

class MemberAddressRequest extends AbstractFormRequest
{
    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [
            'member_id' => 'int|required',
            'Address' => 'string|required|max:65535',
            'city' => 'string|required|max:255',
            'state' => 'string|required|max:255',
            'post_code' => 'string|required|max:255',
            'country' => 'string|required|max:255',
            'isDefault' => 'string|required|max:5'
         ];
    }
}
