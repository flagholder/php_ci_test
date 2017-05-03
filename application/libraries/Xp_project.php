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

    /**
     * Get the full contents of a project
     *
     * @param    int     user ID
     * @param    int     project ID
     * @return   object
     */
    public function viewProject($userId, $projectId)
    {
        if (!$userId || !$projectId) {
            return null;
        }
        $result = $this->ci->projects->getProjectData($projectId);
        return $result;
    }

    /**
     * Get a project list by user ID
     *
     * @param    int     user ID
     * @return   object  project list
     */
    public function getProjectsByUserId($userId)
    {
        if (!$userId) {
            return null;
        }
        log_debug('[project][lib][get_project_by_user_id] Get user_id:' . $userId);
        $result = $this->ci->projects->getProjectsByUserId($userId);
        if (is_null($result)) {
            return null;
        } else {
            return $result;
        }
    }

}
