<?php

/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 2/28/2017
 * Time: 2:07 PM
 */
class User_Test extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $ci =& get_instance();
    }

    public function getUsersNum()
    {
        $num = $this->getCount('users');
        log_message('info', 'count users:'.$num);
        $this->dbError();
    }

}