<?php

/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 3/7/2017
 * Time: 1:09 PM
 */
class Project extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
    }

    public function index()
    {

    }

    public function create()
    {
        $this->load->view('project/create');
    }

    public function edit()
    {

    }

}