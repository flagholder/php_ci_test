<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

/**
 * Auth
 *
 * Authentication library for Code Igniter.
 *
 * @package		Auth
 * @author		Jerry Shen
 * @version		0.1
 * @license		2017 xProjects
 */


class Auth
{
    private $error = array();

    function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->config('tank_auth', TRUE);
        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('tank_auth/users');

        // Try to auto login
        $this->autoLogin();
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
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @return	bool
     */
    function isLogin($activated = TRUE)
    {
        return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
    }


    /**
     * Login user automatically if user provides correct autologin verification
     *
     * @return	bool
     */
    private function autoLogin()
    {
        if (!$this->is_logged_in() AND !$this->is_logged_in(FALSE)) {			// not logged in (as any user)

            $this->ci->load->helper('cookie');
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE)) {

                $data = unserialize($cookie);

                if (isset($data['key']) AND isset($data['user_id'])) {

                    $this->ci->load->model('tank_auth/user_autologin');
                    if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {

                        // Login user
                        $this->ci->session->set_userdata(array(
                            'user_id'	=> $user->id,
                            'username'	=> $user->username,
                            'status'	=> STATUS_ACTIVATED,
                        ));

                        // Renew users cookie to prevent it from expiring
                        set_cookie(array(
                            'name' 		=> $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
                            'value'		=> $cookie,
                            'expire'	=> $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
                        ));

                        $this->ci->users->update_login_info(
                            $user->id,
                            $this->ci->config->item('login_record_ip', 'tank_auth'),
                            $this->ci->config->item('login_record_time', 'tank_auth'));
                        return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }

}
