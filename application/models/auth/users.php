<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package    Tank_auth
 * @author    Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Users extends CI_Model
{
    private $t_users = 'users';            // user accounts
    private $t_user_profiles = 'user_profiles';    // user profiles
    private $db_prefix = 'xp_';

    public function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $this->t_users = $this->db_prefix . $this->t_users;
        $this->t_user_profiles = $this->db_prefix . $this->t_user_profiles;
    }

    /**
     * Get user record by Id
     *
     * @param    int
     * @return   object
     */
    public function getUserById($user_id)
    {
        $this->db->where('id', $user_id);

        $query = $this->db->get($this->t_users);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get user record by login (username or email)
     *
     * @param    string
     * @return    object
     */
    public function get_user_by_login($login)
    {
        $this->db->where('username = ', strtolower($login));
        $this->db->or_where('email = ', strtolower($login));

        $query = $this->db->get($this->t_users);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get user record by username
     *
     * @param    string
     * @return    object
     */
    public function getUserByUsername($username)
    {
        $this->db->where('username = ', strtolower($username));

        $query = $this->db->get($this->t_users);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Get user record by email
     *
     * @param    string
     * @return    object
     */
    public function getUserByEmail($email)
    {
        $this->db->where('email = ', $email);
        $query = $this->db->get($this->t_users);
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Check if username available for registering
     *
     * @param    string
     * @return    bool
     */
    function is_username_available($username)
    {
        $this->db->select('1', false);
        $this->db->where('username = ', strtolower($username));

        $query = $this->db->get($this->t_users);
        return $query->num_rows() == 0;
    }

    /**
     * Check if email available for registering
     *
     * @param    string
     * @return    bool
     */
    public function isEmailAvailable($email)
    {
        $this->db->select('1', false);
        $this->db->where('email = ', $email);

        $query = $this->db->get($this->t_users);
        return $query->num_rows() == 0;
    }

    /**
     * Create new user record
     *
     * @param    array
     * @param    bool
     * @return    array
     */
    public function createUser($data, $activated = false)
    {
//		$data['created_at'] = date('Y-m-d H:i:s');
//		$data['status'] = $activated ? 2 : 1;

        if ($this->db->insert($this->t_users, $data)) {
            $userId = $this->db->insert_id();

//          TODO: modify below
            $activated = true;

            if ($activated) {
                $this->createUserProfile($userId);
            }
            return array('user_id' => $userId);
        }
        return null;
    }

    /**
     * Activate user if activation key is valid.
     * Can be called for not activated users only.
     *
     * @param    int
     * @param    string
     * @param    bool
     * @return    bool
     */
    public function activate_user($user_id, $activation_key, $activate_by_email)
    {
        $this->db->select('1', false);
        $this->db->where('id', $user_id);
        if ($activate_by_email) {
            $this->db->where('new_email_key', $activation_key);
        } else {
            $this->db->where('new_password_key', $activation_key);
        }
        $this->db->where('activated', 0);
        $query = $this->db->get($this->t_users);

        if (1 == $query->num_rows()) {
            $this->db->set('activated', 1);
            $this->db->set('new_email_key', null);
            $this->db->where('id', $user_id);
            $this->db->update($this->t_users);

//            $this->createProfile($user_id);
            return true;
        }
        return false;
    }


    /**
     * Set new password key for user.
     * This key can be used for authentication when resetting user's password.
     *
     * @param    int
     * @param    string
     * @return    bool
     */
    function set_password_key($user_id, $new_pass_key)
    {
        $this->db->set('new_password_key', $new_pass_key);
        $this->db->set('new_password_requested', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);

        $this->db->update($this->t_users);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Check if given password key is valid and user is authenticated.
     *
     * @param    int
     * @param    string
     * @param    int
     * @return bool
     */
    function can_reset_password($user_id, $new_pass_key, $expire_period = 900)
    {
        $this->db->select('1', false);
        $this->db->where('id', $user_id);
        $this->db->where('new_password_key', $new_pass_key);
        $this->db->where('UNIX_TIMESTAMP(new_password_requested) >', time() - $expire_period);

        $query = $this->db->get($this->t_users);
        return $query->num_rows() == 1;
    }

    /**
     * Change user password if password key is valid and user is authenticated.
     *
     * @param    int
     * @param    string
     * @param    string
     * @param    int
     * @return    bool
     */
    function reset_password($user_id, $new_pass, $new_pass_key, $expire_period = 900)
    {
        $this->db->set('password', $new_pass);
        $this->db->set('new_password_key', NULL);
        $this->db->set('new_password_requested', NULL);
        $this->db->where('id', $user_id);
        $this->db->where('new_password_key', $new_pass_key);
        $this->db->where('UNIX_TIMESTAMP(new_password_requested) >=', time() - $expire_period);

        $this->db->update($this->t_users);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Change user password
     *
     * @param    int
     * @param    string
     * @return    bool
     */
    function change_password($user_id, $new_pass)
    {
        $this->db->set('password', $new_pass);
        $this->db->where('id', $user_id);

        $this->db->update($this->t_users);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Set new email for user (may be activated or not).
     * The new email cannot be used for login or notification before it is activated.
     *
     * @param    int
     * @param    string
     * @param    string
     * @param    bool
     * @return    bool
     */
    function set_new_email($user_id, $new_email, $new_email_key, $activated)
    {
        $this->db->set($activated ? 'new_email' : 'email', $new_email);
        $this->db->set('new_email_key', $new_email_key);
        $this->db->where('id', $user_id);
        $this->db->where('activated', $activated ? 1 : 0);

        $this->db->update($this->t_users);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Activate new email (replace old email with new one) if activation key is valid.
     *
     * @param    int
     * @param    string
     * @return    bool
     */
    function activate_new_email($user_id, $new_email_key)
    {
        $this->db->set('email', 'new_email', FALSE);
        $this->db->set('new_email', NULL);
        $this->db->set('new_email_key', NULL);
        $this->db->where('id', $user_id);
        $this->db->where('new_email_key', $new_email_key);

        $this->db->update($this->t_users);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Update user login info, such as IP-address or login time, and
     * clear previously generated (but not activated) passwords.
     *
     * @param    int
     * @param    bool
     * @param    bool
     * @return    void
     */
    public function updateLoginInfo($user_id)
    {
//		$this->db->set('new_password_key', NULL);
//		$this->db->set('new_password_requested', NULL);

        $this->db->set('last_ip', $this->input->ip_address());
        $this->db->set('last_login', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        $this->db->update($this->t_users);
    }

    /**
     * Ban user
     *
     * @param    int
     * @param    string
     * @return    bool
     */
    function banUser($user_id, $reason = '')
    {
        $this->db->where('id', $user_id);
        $this->db->update($this->t_users, array(
            'status' => 3,
        ));

        return $this->db->affected_rows() > 0;
    }

    /**
     * Unban user
     *
     * @param    int
     * @return    bool
     */
    function unbanUser($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->update($this->t_users, array(
            'status' => 1,
        ));

        return $this->db->affected_rows() > 0;
    }

    /**
     * Create an empty profile for a new user
     *
     * @param    int
     * @return   bool
     */
    public function createUserProfile($userId)
    {

        return $this->db->insert($this->t_user_profiles, array('user_id' => $userId));
    }


    /**
     * Update user profile
     *
     * @param    array
     * @return    bool
     */
    public function updateUserProfile($userId, $userProfileData)
    {

        $this->db->set('', $this->input->ip_address());
        $this->db->set('last_login', date('Y-m-d H:i:s'));
        $this->db->where('id', $userId);
        $this->db->update($this->t_user_profiles);

//        return $this->db->insert($this->t_user_profiles, $userProfileData);
        return true;
    }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */