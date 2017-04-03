<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/30/2017
 * Time: 11:14 PM
 */
class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('xp_auth');
        $this->lang->load('auth');

        $this->checkLogin();
    }

    public function index()
    {

    }

    public function showProfile()
    {
        $userInfo = $this->xp_auth->getUserInfo();
        $this->load->view('auth/profile');
        print_r($userInfo);

    }

    public function editProfile()
    {

    }

    private function checkLogin()
    {
        $loginStatus = $this->xp_auth->isLogin();
        if ($loginStatus === DEF::USER_STATUS_BANNED) {
            $this->load->view('errors/error_message');
        } elseif ($loginStatus === DEF::USER_STATUS_NOT_ACTIVATED) {
            redirect(base_url('auth/send_again/'));
        } elseif ($loginStatus === DEF::USER_STATUS_ACTIVATED) {
            return true;
        } else {
            redirect(base_url('auth/login'));
        }
        return false;
    }
}
