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

    public function index()
    {
        $this->load->view('welcome_message');
    }
}
