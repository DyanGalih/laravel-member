<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Requests;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 03:24:51
 * Time: 2020/05/09
 * Class MemberRepositoryRequest
 * @package WebAppId\Member\Repositories\Requests
 */
class MemberRepositoryRequest
{

    /**
     * @var int
     */
    public $identity_type_id;

    /**
     * @var string
     */
    public $identity;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $phone_alternative;

    /**
     * @var string
     */
    public $sex;

    /**
     * @var string
     */
    public $dob;

    /**
     * @var int
     */
    public $timezone_id;

    /**
     * @var int
     */
    public $language_id;

    /**
     * @var int
     */
    public $content_id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $creator_id;

    /**
     * @var int
     */
    public $owner_id;

    /**
     * @var int
     */
    public $profile_id;
}
