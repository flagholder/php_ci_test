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
    }


    /**
     * Create a new project
     *
     * @param    int     user ID
     * @param    string  project title
     * @param    date    project start datetime
     * @param    date    project end datetime
     * @param    string  user grade
     * @param    string  project contents
     * @return   boolean
     */
    public function createProject($userId, $title, $startAt, $endAt, $grade, $content)
    {
        $userId = 2;

        $data = array(
            'uid' => $userId,
            'title' => $title,
            'content' => $content,
            'grade' => $grade
        );
        $this->ci->projects->createProject($data);

        return true;
    }

    public function getProjectByUserId($userId)
    {
        if (!$userId) {
            return null;
        }

        $result = $this->ci->projects->getProjectsByUserId($userId);
        if (is_null($result)) {
            return null;
        } else {
            return $result;
        }
    }

}
