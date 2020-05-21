<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Requests;

use WebAppId\Content\Requests\ContentRequest;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberService
 * @package WebAppId\Member\Requests
 */
class MemberRequest extends ContentRequest
{
    /**
     * @inheritDoc
     */
    function rules(): array
    {
        $content = parent::rules();
        $member = [
            'identity_type_id' => 'int|required',
            'identity' => 'string|required|max:191|unique:members,identity',
            'name' => 'string|required|max:191',
            'email' => 'string|required|max:100|unique:members,email',
            'phone' => 'string|required|max:20',
            'phone_alternative' => 'string|required|max:191',
            'sex' => 'string|required|max:1',
            'dob' => 'string',
            'timezone_id' => 'int',
            'language_id' => 'int',
            'title' => 'string|max:191',
            'content' => 'string',
            'default_image' => 'int|nullable'
        ];
        return array_merge($content, $member);
    }
}
