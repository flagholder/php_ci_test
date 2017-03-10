<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login_attempts
 *
 * This model serves to watch on all attempts to login on the site
 * (to protect the site from brute-force attack to user database)
 *
 * @package    Tank_auth
 * @author     Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Login_attempts extends CI_Model
{
    private $t_login_attempts = 'login_attempts';

    public function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $this->t_login_attempts = $ci->config->item('db_table_prefix', 'xp_config') . $this->t_login_attempts;
    }

    /**
     * Get number of attempts to login occured from given IP-address or login
     *
     * @param    string
     * @param    string
     * @return    int
     */
    public function getAttemptsNum($ip_address, $login)
    {
        $this->db->select('1', false);
        $this->db->where('ip_address', $ip_address);
        if (strlen($login) > 0) {
            $this->db->or_where('login', $login);
        }
        $qres = $this->db->get($this->t_login_attempts);
        return $qres->num_rows();
    }

    /**
     * Increase number of attempts for given IP-address and login
     *
     * @param   string
     * @param   string
     * @return  void
     */
    public function increaseAttempt($ip_address, $login)
    {
        $this->db->insert($this->t_login_attempts, array('ip_address' => $ip_address, 'login' => $login));
    }

    /**
     * Clear all attempt records for given IP-address and login.
     * Also purge obsolete login attempts (to keep DB clear).
     *
     * @param   string
     * @param   string
     * @param   int
     * @return  void
     */
    public function clearAttempts($ip_address, $login, $expire_period = 86400)
    {
        $this->db->where(array('ip_address' => $ip_address, 'login' => $login));

        // Purge obsolete login attempts
        $this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);
        $this->db->delete($this->t_login_attempts);
    }
}

/* End of file login_attempts.php */
/* Location: ./application/models/auth/login_attempts.php */
