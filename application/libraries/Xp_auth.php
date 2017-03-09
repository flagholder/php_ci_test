<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * XpAuth
 *
 * Authentication library
 *
 * @package    Auth
 * @author     Jerry Shen
 * @version    0.1
 * @license    2017 xProjects
 */

/**
 * XpAuth
 *
 * Authentication library
 *
 * @package     Auth
 * @author      Jerry Shen
 * @version     0.1
 * @license     X-Projects Copyright (c) 2017
 */
class Xp_auth
{
    private $error = array();

    public function __construct()
    {
        $this->ci =& get_instance();
        require_once('Include/define.inc.php');
        $this->ci->load->config('tank_auth', true);
        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('auth/users');

        // Try to auto login
        $loginResult = $this->autoLogin();
        log_debug('auto login result ' . (int)$loginResult);
    }

    /**
     * Login user automatically if user provides correct autologin verification
     *
     * @return    bool
     */
    private function autoLogin()
    {
        if (!$this->isLoggedIn() and !$this->isLoggedIn(false)) {
            // not logged in (as any user)

//            $this->ci->load->helper('cookie');
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), true)) {
                $data = unserialize($cookie);

                if (isset($data['key']) and isset($data['user_id'])) {
                    $this->ci->load->model('tank_auth/user_autologin');
                    if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {
                        // Login user
                        $this->ci->session->set_userdata(array(
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'status' => DEF::USER_STATUS_ACTIVATED,
                        ));

                        // Renew users cookie to prevent it from expiring
                        set_cookie(array(
                            'name' => $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
                            'value' => $cookie,
                            'expire' => $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
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
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param     bool
     * @return    bool
     */
    public function isLoggedIn($activated = true)
    {
//        log_debug('session status :'.$this->ci->session->userdata('status').' - '.DEF::USER_STATUS_ACTIVATED);
        $activated = $activated ? (string)DEF::USER_STATUS_ACTIVATED : (string)DEF::USER_STATUS_NOT_ACTIVATED;
        return $this->ci->session->userdata('status') === $activated;
    }

    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param    bool
     * @return   bool
     */
    public function isLogin()
    {
//        log_debug('actived '.DEF::USER_STATUS_ACTIVATED);

//        $isLogin = $this->is_logged_in() ? 'true' : 'false';
//        log_debug('is login :'.$isLogin);

        return $this->isLoggedIn();
    }

    /**
     * Logout user from the site
     *
     * @return  void
     */
    public function logout()
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
     * @param   string
     * @param   string
     * @param   string
     * @param   string
     * @param   bool
     * @return  array
     */
    public function createUser($username, $email, $password, $ip, $email_activation = false)
    {
        if (!$this->ci->users->isEmailAvailable($email)) {
            $this->error = array('email' => 'auth_email_in_use');
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = array(
                'email' => $email,
                'username' => $username,
                'password' => $hashed_password,
                'status' => $email_activation ? 1 : 2,
                'last_ip' => $ip,
            );

            if ($email_activation) {
                $data['new_email_key'] = md5(rand() . microtime());
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
     * @return  array
     */
    public function getErrorMessage()
    {
        return $this->error;
    }

    /**
     * Create CAPTCHA image to verify user as a human
     *
     * @return    string
     */
    public function createCaptcha()
    {
        $this->ci->load->helper('captcha');

        $cap = create_captcha(array(
            'img_path'   => './' . $this->ci->config->item('captcha_path', 'xp_config'),
            'img_url'    => base_url() . $this->ci->config->item('captcha_path', 'xp_config'),
            'font_path'  => './' . $this->ci->config->item('captcha_fonts_path', 'xp_config'),
            'font_size'  => $this->ci->config->item('captcha_font_size', 'xp_config'),
            'img_width'  => $this->ci->config->item('captcha_width', 'xp_config'),
            'img_height' => $this->ci->config->item('captcha_height', 'xp_config'),
            'show_grid'  => $this->ci->config->item('captcha_grid', 'xp_config'),
            'expiration' => $this->ci->config->item('captcha_expire', 'xp_config'),
        ));

        // Save captcha params in session
        $this->ci->session->set_flashdata(array(
            'captcha_word' => $cap['word'],
            'captcha_time' => $cap['time'],
        ));

        return $cap['image'];
    }

    /**
     * Create reCAPTCHA JS and non-JS HTML to verify user as a human
     *
     * @return    string
     */
    public function createRecaptcha()
    {
        $this->ci->load->helper('recaptcha');

        // Add custom theme so we can get only image
        $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

        // Get reCAPTCHA JS and non-JS HTML
        $html = recaptcha_get_html($this->ci->config->item('recaptcha_public_key', 'xp_config'));

        return $options . $html;
    }
}
