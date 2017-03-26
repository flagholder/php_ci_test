<?php
/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 2/24/2017
 * Time: 1:21 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->load->model('test/user_test', '', TRUE);
        $this->user_test->count_users();
        $this->load->view('welcome_message');
    }

    public function viewProfile()
    {
        $this->load->view('auth/profile');
    }
}
