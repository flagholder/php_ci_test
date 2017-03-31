<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/30/2017
 * Time: 11:14 PM
 */
class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('xp_auth');
        $this->lang->load('auth');
    }

    public function index()
    {

    }

    public function showProfile()
    {

    }

    public function editProfile()
    {

    }

}