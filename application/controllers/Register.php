<?php

if (defined('BASEPATH') === false) {
    exit('No direct script access allowed');
}

/**
 * MyClass File Doc Comment
 *
 * @category  MyClass
 * @package   MyPackage
 * @author    Jerry Shen
 * @license
 * @link
 *
 */

/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 3/3/2017
 * Time: 3:11 PM
 */

class Register extends MY_Controller
{
    /**
     * Construction
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->lang->load('auth');
    }

    /**
     * Index page, show registration form
     *
     * @return void
     */
    public function index()
    {
        // TODO
        // check if user login or not ?
        $redirectUrl = $this->input->get_post('redurl');

        // if need captcha when register
        $show_captcha = false; //$this->access->is_reg_captcha($ip);

        $data = array(
            'redurl'        => $redirectUrl,
            'show_captcha'  => $show_captcha ? 'true' : 'false',
            'selected'      => 'home'
        );

        $this->load->view('auth/register', $data);
    }

    /**
     * Create a new account
     *
     * @return void
     */
    public function submit()
    {
        $this->load->library('xp_auth');

        $ip = $this->input->ip_address();
        $redurl = $this->input->get_post('redurl') ? $this->input->get_post('redurl') : site_url('home/');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $callback  = $this->input->get_post('callback');

        log_info(
            sprintf(
                '[register][submit] ip=%s, email=%s, username=%s, redurl=%s, callback=%s ',
                $ip,
                $email,
                $username,
                $redurl,
                $callback
            )
        );

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|strtolower');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'trim|required|min_length[' . $this->config->item('username_min_length', 'xp_config') . ']|max_length[' . $this->config->item('username_max_length', 'xp_config') . ']|alpha_dash|strtolower'
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'trim|required|min_length[' . $this->config->item('password_min_length', 'xp_config') . ']|max_length[' . $this->config->item('password_max_length', 'xp_config') . ']|alpha_dash'
        );
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

        $captchaRegistration = $this->config->item('captcha_registration', 'xp_config');
        $useRecaptcha = $this->config->item('use_recaptcha', 'xp_config');
        if ($captchaRegistration) {
            if ($useRecaptcha) {
                $this->form_validation->set_rules(
                    'recaptcha_response_field',
                    'Confirmation Code',
                    'trim|required|callback__check_recaptcha'
                );
            } else {
                $this->form_validation->set_rules(
                    'captcha',
                    'Confirmation Code',
                    'trim|required|callback__check_captcha'
                );
            }
        }

        $data['errors'] = array();
        $email_activation = $this->config->item('email_activation', 'xp_config');
        $validateResult = $this->form_validation->run();
        log_info('[register][validation] result='.($validateResult ? 'true' : 'false'));

        if ($validateResult) {
            // validation ok
            $data = $this->xp_auth->createUser(
                $this->form_validation->set_value('username'),
                $this->form_validation->set_value('email'),
                $this->form_validation->set_value('password'),
                $email_activation
            );

            if (!is_null($data)) {
                // create user success
                $data['site_name'] = $this->config->item('website_name', 'xp_config');
                if ($email_activation) {
                    // send activation email
                    $data['activation_period'] = $this->config->item('email_activation_expire', 'xp_config') / 3600;
//                    $this->_send_email('activate', $data['email'], $data);
                    unset($data['password']);
                    // show registration completed
                    redirect('/auth/');
                } else {
                    if ($this->config->item('email_account_details', 'xp_config')) {
                        // send "welcome" email
                        $this->xp_auth->sendEmail('welcome', $data['email'], $data);
                    }
                    unset($data['password']);
                    // show registration completed
                    $this->load->view('auth/login');
                    return;
                }
            } else {
                $errors = $this->xp_auth->getErrorMessage();
                foreach ($errors as $k => $v) {
                    $data['errors'][$k] = $this->lang->line($v);
                }
            }
        }

        if ($captchaRegistration) {
            if ($useRecaptcha) {
                $data['recaptcha_html'] = $this->xp_auth->createRecaptcha();
            } else {
                $data['captcha_html'] = $this->xp_auth->createCaptcha();
            }
        }
//        $data['use_username'] = $use_username;
        $data['captcha_registration'] = $captchaRegistration;
        $data['use_recaptcha'] = $useRecaptcha;
        $this->load->view('auth/register', $data);
    }
}
