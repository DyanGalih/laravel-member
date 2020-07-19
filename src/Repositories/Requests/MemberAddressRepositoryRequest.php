<?php
/**
 * Created by LazyCrud - @DyanGalih <dyan.galih@gmail.com>
 */

namespace WebAppId\Member\Repositories\Requests;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 12:05:34
 * Time: 2020/05/09
 * Class MemberAddressRepositoryRequest
 * @package WebAppId\Member\Repositories\Requests
 */
class MemberAddressRepositoryRequest
{

    /**
     * @var int
     */

    public $type_id;

    /**
     * @var string
     */

    public $code;

    /**
     * @var string
     */

    public $name;

    /**
     * @var int
     */
    public $member_id;
                
    /**
     * @var string
     */
    public $address;
                
    /**
     * @var string
     */
    public $city;
                
    /**
     * @var string
     */
    public $state;
                
    /**
     * @var string
     */
    public $post_code;
                
    /**
     * @var string
     */
    public $country;
                
    /**
     * @var string
     */
    public $isDefault;
                
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
                
}
