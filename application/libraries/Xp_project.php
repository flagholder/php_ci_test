<?php

/**
 * Xp_Project
 *
 * Project library
 *
 * @package    Project
 * @author     Jerry Shen
 * @version    0.1
 * @license    2017 xProjects
 */

/**
 * Xp_project
 *
 * Project library
 *
 * @package     Project
 * @author      Jerry Shen
 * @version     0.1
 * @license     X-Projects Copyright (c) 2017
 */
class Xp_project
{
    private $error = array();

    public function __construct()
    {
        $this->ci =& get_instance();

        require_once('Include/define.inc.php');
        $this->ci->load->config('xp_config', true);
        $this->ci->load->library('session');
        $this->ci->load->database();
        $this->ci->load->model('project/projects');

        // Try to auto login
//        $loginResult = $this->autoLogin();
//        log_debug('auto login result ' . (int)$loginResult);
    }


    public function createProject($title, $startAt, $endAt, $grade, $content)
    {
        $uid = 2;

        $data = array(
            'uid' => $uid,
            'title' => $title,
            'content' => $content,
            'grade' => $grade
        );
        $this->ci->projects->createProject($data);

        return null;
    }

}
