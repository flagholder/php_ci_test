<?php

/**
 * Projects
 *
 * This model represents projects data. It operates the following tables:
 * - projects,
 *
 * @package    Project
 * @author    Jerry Shen
 */
class projects extends MY_Model
{
    private $t_projects = 'projects';
    private $db_prefix = 'xp_';

    public function __construct()
    {
        parent::__construct();

        $ci =& get_instance();
        $this->t_projects = $this->db_prefix . $this->t_projects;
    }

    /**
     * Create new project record
     *
     * @param    array
     * @param    bool
     * @return   array
     */
    public function createProject($data)
    {
        if ($this->db->insert($this->t_projects, $data)) {
            $projectId = $this->db->insert_id();
            return array('project_id' => $projectId);
        }
        return null;
    }

}
