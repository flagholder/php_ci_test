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
        $this->load->library('xp_auth');
    }

    public function index()
    {
        $data = array(
            'selected' => 'home'
        );

        if ($this->xp_auth->isLogin()) {
            $this->load->view('home/index', $data);
        } else {
            redirect('/auth/login');
        }


    }

}