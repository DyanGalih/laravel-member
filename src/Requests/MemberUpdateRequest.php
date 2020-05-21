<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\Member\Requests;


/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 20/05/2020
 * Time: 23.12
 * Class MemberUpdateRequest
 * @package WebAppId\Member\Requests
 */
class MemberUpdateRequest extends MemberRequest
{
    public function rules(): array
    {
        $ruleList = parent::rules();
        $ruleList['identity'] = 'string|required|max:191';
        $ruleList['email'] = 'string|required|max:100';
        return $ruleList;
    }
}