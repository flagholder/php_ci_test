<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 2/28/2017
 * Time: 4:19 PM
 */
class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {
        $data = array(
            'selected' => 'home'
        );

        if ($this->auth->isLogin()) {
            $this->load->library('accountinfo');
            $this->loginVerify(true);
            $user_info = $this->accountinfo->getLoginInfo($this->_uuid);
            $data['user_info'] = $user_info;

//            $this->load->library('bind_info');
//            $data['user_info']['is_bind_email']  = $this->bind_info->bind_status($this->_uuid,'email');
//            $data['user_info']['is_bind_mobile'] = $this->bind_info->bind_status($this->_uuid,'mobile');

        } else {
            $data['user_info'] = array(
                'nickname' => '',
                'loginname' => '',
                'points' => '',     //积分
                'level' => '',
                'is_bind_mobile' => false,
                'is_bind_email' => false
            );
        }
        $data['show_captcha'] = $this->access->is_login_captcha($this->input->ip_address());
        $this->template->load('', 'home/index', $data);

    }

}