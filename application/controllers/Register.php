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
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // TODO
        // check if user login or not ?

        $ip = $this->input->ip_address();
        $redirectUrl = $this->input->get('redurl');

        // if need captcha when register
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
        $this->load->library('tank_auth');

        $ip = $this->input->ip_address();
        $redurl = $this->input->get_post('redurl') ? $this->input->get_post('redurl') :
            ($this->input->get('redurl') ? $this->input->get('redurl') : site_url('home/'));
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $callback  = $this->input->get('callback') ?  $this->input->get('callback') :  $this->input->post('callback');

        log_debug(sprintf('[register][submit] ip=%s, email=%s, username=%s, redurl=%s, ',
            $ip, $email, $username, $redurl));

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|strtolower');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[' . $this->config->item('username_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('username_max_length', 'tank_auth') . ']|alpha_dash|strtolower');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']|alpha_dash');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

        $captcha_registration = $this->config->item('captcha_registration', 'tank_auth');
        $use_recaptcha = $this->config->item('use_recaptcha', 'tank_auth');
        if ($captcha_registration) {
            if ($use_recaptcha) {
                $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|required|callback__check_recaptcha');
            } else {
                $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|required|callback__check_captcha');
            }
        }
        $data['errors'] = array();

        $email_activation = $this->config->item('email_activation', 'tank_auth');

        $validateResult = $this->form_validation->run();
        log_debug('[register][validation] result='.($validateResult ? 'true' : 'false'));

        if ($validateResult) {                                // validation ok
            if (!is_null($data = $this->tank_auth->create_user(
                $this->form_validation->set_value('username'),
                $this->form_validation->set_value('email'),
                $this->form_validation->set_value('password'),
                $email_activation))
            ) {                                    // success

                $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                if ($email_activation) {                                    // send "activate" email
                    $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

//                    $this->_send_email('activate', $data['email'], $data);

                    unset($data['password']); // Clear password (just for any case)

//                    $this->_show_message($this->lang->line('auth_message_registration_completed_1'));
                    // show registration completed
                    redirect('/auth/');

                } else {
                    if ($this->config->item('email_account_details', 'tank_auth')) {    // send "welcome" email

//                        $this->_send_email('welcome', $data['email'], $data);
                    }
                    unset($data['password']); // Clear password (just for any case)

//                    $this->_show_message($this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/auth/login/', 'Login'));
                    // show registration completed
//                    redirect('/auth/');
                    $this->load->view('auth/login');
                }
            } else {
                $errors = $this->tank_auth->get_error_message();
                foreach ($errors as $k => $v) $data['errors'][$k] = $this->lang->line($v);
            }
        }
        if ($captcha_registration) {
            if ($use_recaptcha) {
                $data['recaptcha_html'] = $this->_create_recaptcha();
            } else {
                $data['captcha_html'] = $this->_create_captcha();
            }
        }
//        $data['use_username'] = $use_username;
        $data['captcha_registration'] = $captcha_registration;
        $data['use_recaptcha'] = $use_recaptcha;
        $this->load->view('auth/register', $data);
    }


}