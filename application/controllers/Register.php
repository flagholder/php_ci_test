<?php

/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 3/3/2017
 * Time: 3:11 PM
 */
class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // TODO
        // check if user login or not ?

        $ip = $this->input->ip_address();
        $redirectUrl = $this->input->get('redurl');

        // 是否需要显示验证码图片
        $show_captcha = false; //$this->access->is_reg_captcha($ip);

        $data = array(
            'redurl' => $redirectUrl,
            'show_captcha' => $show_captcha ? 'true' : 'false',
            'selected' => 'home'
        );
        $this->load->view('auth/register', $data);
    }

    public function submit()
    {


    }

}