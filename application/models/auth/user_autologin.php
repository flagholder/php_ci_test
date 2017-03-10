<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User_Autologin
 *
 * This model represents user autologin data. It can be used
 * for user verification when user claims his autologin passport.
 *
 * @package    Xp_auth
 * @author     Jerry Shen
 */
class User_Autologin extends CI_Model
{
    private $table_user_autologin = 'user_autologin';
    private $table_users = 'users';

    public function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $this->table_user_autologin = $ci->config->item('db_table_prefix', 'xp_config') . $this->table_user_autologin;
        $this->table_users = $ci->config->item('db_table_prefix', 'xp_config') . $this->table_users;
    }

    /**
     * Get user data for auto-logged in user.
     * Return NULL if given key or user ID is invalid.
     *
     * @param    int
     * @param    string
     * @return   object
     */
    public function get($user_id, $key)
    {
        $this->db->select($this->table_users . '.id');
        $this->db->select($this->table_users . '.username');
        $this->db->from($this->table_users);
        $this->db->join($this->table_user_autologin, $this->table_user_autologin . '.user_id = ' . $this->table_users . '.id');
        $this->db->where($this->table_user_autologin . '.user_id', $user_id);
        $this->db->where($this->table_user_autologin . '.key_id', $key);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return null;
    }

    /**
     * Save data for user's autologin
     *
     * @param    int
     * @param    string
     * @return   bool
     */
    public function set($user_id, $key)
    {
        return $this->db->insert($this->table_user_autologin, array(
            'user_id'   => $user_id,
            'key_id'    => $key,
            'user_agent'=> substr($this->input->user_agent(), 0, 149),
            'last_ip'   => $this->input->ip_address(),
        ));
    }

    /**
     * Delete user's autologin data
     *
     * @param    int
     * @param    string
     * @return   void
     */
    public function delete($user_id, $key)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('key_id', $key);
        $this->db->delete($this->table_user_autologin);
    }

    /**
     * Delete all autologin data for given user
     *
     * @param    int
     * @return   void
     */
    public function clear($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->table_user_autologin);
    }

    /**
     * Purge autologin data for given user and login conditions
     *
     * @param    int
     * @return    void
     */
    public function purge($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
        $this->db->where('last_ip', $this->input->ip_address());
        $this->db->delete($this->table_user_autologin);
    }
}

/* End of file user_autologin.php */
/* Location: ./application/models/auth/user_autologin.php */