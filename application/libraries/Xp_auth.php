<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

require_once('Include/define.inc.php');

/**
 * Auth
 *
 * Authentication library
 *
 * @package		Auth
 * @author		Jerry Shen
 * @version		0.1
 * @license		2017 xProjects
 */

/**
 * Auth
 *
 * Authentication library
 *
 * @package		Auth
 * @author		Jerry Shen
 * @version		0.1
 * @license		X-Projects Copyright (c) 2017
 */

class Xp_auth
{
    private $error = array();

    function __construct()
    {
        $this->ci =& get_instance();
        require_once('Include/define.inc.php');
        $this->ci->load->config('tank_auth', TRUE);
        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('auth/users');

        // Try to auto login
        $loginResult = $this->autoLogin();
        log_debug('auto login result '.(int)$loginResult);
    }



    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @return	bool
     */
    function isLogin()
    {
//        log_debug('actived '.DEF::USER_STATUS_ACTIVATED);

//        $isLogin = $this->is_logged_in() ? 'true' : 'false';
//        log_debug('is login :'.$isLogin);

        return $this->is_logged_in();
    }


    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @return	bool
     */
    function is_logged_in($activated = TRUE)
    {
//        log_debug('session status :'.$this->ci->session->userdata('status').' - '.DEF::USER_STATUS_ACTIVATED);
        return $this->ci->session->userdata('status') === ($activated ? (string) DEF::USER_STATUS_ACTIVATED : (string) DEF::USER_STATUS_NOT_ACTIVATED);
    }

    /**
     * Login user automatically if user provides correct autologin verification
     *
     * @return	bool
     */
    private function autoLogin()
    {
        if (!$this->is_logged_in() AND !$this->is_logged_in(false)) {			// not logged in (as any user)

//            $this->ci->load->helper('cookie');
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

                $data = unserialize($cookie);

                if (isset($data['key']) AND isset($data['user_id'])) {

                    $this->ci->load->model('tank_auth/user_autologin');
                    if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

                        // Login user
                        $this->ci->session->set_userdata(array(
                            'user_id'	=> $user->id,
                            'username'	=> $user->username,
                            'status'	=> DEF::USER_STATUS_ACTIVATED,
                        ));

                        // Renew users cookie to prevent it from expiring
                        set_cookie(array(
                            'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
                            'value'		=> $cookie,
                            'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
                        ));

                        $this->ci->users->update_login_info($user->id);

                        // Todo:
                        // - add login history?

                        return true;
                    }
                }
            }
        }
        return false;
    }



    /**
     * Logout user from the site
     *
     * @return	void
     */
    function logout()
    {
        $this->delete_autologin();

        // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
        $this->ci->session->set_userdata(array('user_id' => '', 'username' => '', 'status' => ''));

        $this->ci->session->sess_destroy();
    }


    /**
     * Create new user on the site and return some data about it:
     * user_id, username, password, email, new_email_key (if any).
     *
     * @param	string
     * @param	string
     * @param	string
     * @param   string
     * @param	bool
     * @return	array
     */
    function createUser($username, $email, $password, $ip, $email_activation=false)
    {
        if (! $this->ci->users->isEmailAvailable($email)) {
            $this->error = array('email' => 'auth_email_in_use');

        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = array(
                'email'		=> $email,
                'username'	=> $username,
                'password'	=> $hashed_password,
                'status'    => $email_activation ? 1 : 2,
                'last_ip'	=> $ip,
            );

            if ($email_activation) {
                $data['new_email_key'] = md5(rand().microtime());
            }
            if (!is_null($res = $this->ci->users->createUser($data, !$email_activation))) {
                $data['user_id'] = $res['user_id'];
                $data['password'] = $password;
                unset($data['last_ip']);
                return $data;
            }
        }
        return null;
    }

    /**
     * Get error message.
     * Can be invoked after any failed operation such as login or register.
     *
     * @return	string
     */
    function get_error_message()
    {
        return $this->error;
    }


}
