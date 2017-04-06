<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 2/28/2017
 * Time: 4:19 PM
 */
class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {
        $this->load->library('xp_auth');
        $data = array(
            'selected' => 'home'
        );

        if ($this->xp_auth->isLogin()) {
            $data = $this->xp_auth->getUserInfo();
            log_debug('[home][index] user info :' . $data['id']);
            $this->load->view('home/index', $data);
        } else {
            redirect('/auth/login');
        }
    }
}
