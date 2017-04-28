<?php

/**
 * Xp_upload
 *
 * File upload library
 *
 * @package     Project
 * @author      Jerry Shen
 * @version     0.1
 * @license     X-Projects Copyright (c) 2017
 */
class Xp_upload
{
    private $error = array();


    public function __construct()
    {
        $this->ci =& get_instance();
        require_once('Include/define.inc.php');
        $this->ci->load->config('xp_config', true);
        $this->ci->load->library('session');
        $this->ci->load->database();
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }


}