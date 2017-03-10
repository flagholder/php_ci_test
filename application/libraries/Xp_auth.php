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
        $this->ci->load->config('xp_config', true);
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
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'xp_config'), true)) {
                $data = unserialize($cookie);

                if (isset($data['key']) and isset($data['user_id'])) {
                    $this->ci->load->model('auth/user_autologin');
                    if (!is_null($user = $this->ci->user_autologin->get($data['user_id'], md5($data['key'])))) {
                        // Login user
                        $this->ci->session->set_userdata(array(
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'status' => DEF::USER_STATUS_ACTIVATED,
                        ));

                        // Renew users cookie to prevent it from expiring
                        set_cookie(array(
                            'name' => $this->ci->config->item('autologin_cookie_name', 'xp_config'),
                            'value' => $cookie,
                            'expire' => $this->ci->config->item('autologin_cookie_life', 'xp_config'),
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
     * @return   int
     */
    public function isLogin()
    {
        $loginStatus = $this->ci->session->userdata('status');
        if (!$loginStatus) {
            return 0;
        }
        return $loginStatus;
    }

    /**
     * Login user on the site. Return TRUE if login is successful
     * (user exists and activated, password is correct), otherwise FALSE.
     *
     * @param    string (username or email or both depending on settings in config file)
     * @param    string
     * @param    bool
     * @return    bool
     */
    public function login($login, $password, $remember)
    {
        if ((strlen($login) > 0) and (strlen($password) > 0)) {
            $get_user_func = 'get_user_by_email';

            if (!is_null($user = $this->ci->users->$get_user_func($login))) {
                // Find user by email successfully

                // Does password match hash in database?

                if ($hasher->CheckPassword($password, $user->password)) {        // password ok

                    if ($user->banned == 1) {                                    // fail - banned
                        $this->error = array('banned' => $user->ban_reason);

                    } else {
                        $this->ci->session->set_userdata(array(
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'status' => ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                        ));

                        if ($user->activated == 0) {                            // fail - not activated
                            $this->error = array('not_activated' => '');

                        } else {                                                // success
                            if ($remember) {
                                $this->create_autologin($user->id);
                            }

                            $this->clear_login_attempts($login);

                            $this->ci->users->update_login_info(
                                $user->id,
                                $this->ci->config->item('login_record_ip', 'tank_auth'),
                                $this->ci->config->item('login_record_time', 'tank_auth'));
                            return TRUE;
                        }
                    }
                } else {                                                        // fail - wrong password
                    $this->increase_login_attempt($login);
                    $this->error = array('password' => 'auth_incorrect_password');
                }
            } else {                                                            // fail - wrong login
                $this->increase_login_attempt($login);
                $this->error = array('login' => 'auth_incorrect_login');
            }
        }
        return false;
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
            'img_path' => './' . $this->ci->config->item('captcha_path', 'xp_config'),
            'img_url' => base_url() . $this->ci->config->item('captcha_path', 'xp_config'),
            'font_path' => './' . $this->ci->config->item('captcha_fonts_path', 'xp_config'),
            'font_size' => $this->ci->config->item('captcha_font_size', 'xp_config'),
            'img_width' => $this->ci->config->item('captcha_width', 'xp_config'),
            'img_height' => $this->ci->config->item('captcha_height', 'xp_config'),
            'show_grid' => $this->ci->config->item('captcha_grid', 'xp_config'),
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

    /**
     * Send email message of given type (activate, forgot_password, etc.)
     *
     * @param    string
     * @param    string
     * @param    array
     * @return    void
     */
    public function sendEmail($type, $email, &$data)
    {
        $this->ci->load->library('email');
        $this->ci->email->from(
            $this->ci->config->item('webmaster_email', 'xp_config'),
            $this->ci->config->item('website_name', 'xp_config')
        );

        $this->ci->email->reply_to(
            $this->ci->config->item('webmaster_email', 'tank_auth'),
            $this->ci->config->item('website_name', 'tank_auth')
        );
        $this->ci->email->to($email);
        $this->ci->email->subject(
            sprintf(
                $this->ci->lang->line('auth_subject_' . $type),
                $this->ci->config->item('website_name', 'xp_config')
            )
        );
        $this->ci->email->message($this->ci->load->view('email/' . $type . '-html', $data, true));
        $this->ci->email->set_alt_message($this->ci->load->view('email/' . $type . '-txt', $data, true));
        // TODO: unmark line below to send email
//        $this->ci->email->send();
        log_debug('[auth][send_email] ' . $type . ' ' . $email);
    }

    /**
     * Check if login attempts exceeded max login attempts (specified in config)
     *
     * @param   string
     * @return  bool
     */
    public function isMaxLoginAttemptsExceeded($login)
    {
        if ($this->ci->config->item('login_count_attempts', 'xp_config')) {
            $this->ci->load->model('auth/login_attempts');
            $currentLoginAttempts = $this->ci->login_attempts->get_attempts_num($this->ci->input->ip_address(), $login);
            return $currentLoginAttempts >= $this->ci->config->item('login_max_attempts', 'tank_auth');
        }
        return false;
    }

    /**
     * Increase number of attempts for given IP-address and login
     * (if attempts to login is being counted)
     *
     * @param   string
     * @return  void
     */
    private function increaseLoginAttempt($login)
    {
        if ($this->ci->config->item('login_count_attempts', 'xp_config')) {
            if (!$this->isMaxLoginAttemptsExceeded($login)) {
                $this->ci->load->model('auth/login_attempts');
                $this->ci->login_attempts->increase_attempt($this->ci->input->ip_address(), $login);
            }
        }
    }

    /**
     * Clear all attempt records for given IP-address and login
     * (if attempts to login is being counted)
     *
     * @param   string
     * @return  void
     */
    private function clearLoginAttempts($login)
    {
        if ($this->ci->config->item('login_count_attempts', 'xp_config')) {
            $this->ci->load->model('auth/login_attempts');
            $this->ci->login_attempts->clear_attempts(
                $this->ci->input->ip_address(),
                $login,
                $this->ci->config->item('login_attempt_expire', 'xp_config')
            );
        }
    }
}
