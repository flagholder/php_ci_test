<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/30/2017
 * Time: 11:14 PM
 */
class User extends MY_Controller
{

    private $userInfo = array();

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('xp_auth');
        $this->lang->load('auth');

        $this->checkLogin();
        $this->userInfo = $this->xp_auth->getUserInfo();
    }

    public function index()
    {

    }

    public function showProfile()
    {
        $userProfile = $this->xp_auth->getUserProfile($this->userInfo['id']);
        $data = array_merge($this->userInfo, $userProfile);
        $this->load->view('auth/profile', $data);
    }

    public function editProfile()
    {
        $ip = $this->input->ip_address();
        $school = $this->input->post('school');
        $birthday = $this->input->post('birthday');
        $grade = $this->input->post('grade');
        $phone = $this->input->post('phone');
        $tags = $this->input->post('tags');

        log_info(
            sprintf(
                '[user][profile_edit] user_id=%s, school=%s, birthday=%s, grade=%s, phone=%s, tags=%s ',
                $this->userInfo['id'],
                $school,
                $birthday,
                $grade,
                $phone,
                $tags
            )
        );

        $this->form_validation->set_rules('school', 'School', 'trim');
        $this->form_validation->set_rules('birthday', 'Birthday', 'trim|alpha_dash');
        $this->form_validation->set_rules('grade', 'Grade', 'trim|alpha_dash');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|alpha_dash');
        $this->form_validation->set_rules('tags', 'Tags', 'trim');


        $data['errors'] = array();
        $validateResult = $this->form_validation->run();

        if ($validateResult) {
            $updateResult = $this->xp_auth->updateUserProfile(
                $this->userInfo['id'],
                $this->form_validation->set_value('school'),
                $this->form_validation->set_value('grade'),
                $this->form_validation->set_value('birthday'),
                $this->form_validation->set_value('tags')
            );
            if ($updateResult) {
                redirect(base_url('home/'));
            } else {
                $data['errors'] = 'update profile error!';
                $this->load->view('errors/error_message', $data);
            }
        } else {
            $this->load->view('auth/showprofile');
        }
    }

    public function updateAvatar()
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
