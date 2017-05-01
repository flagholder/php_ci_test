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
class Projects extends MY_Model
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

    /**
     * Get a project detailed data by project ID
     *
     * @param    int     project ID
     * @return   object  project data
     */
    public function getProjectData($projectId)
    {
        $this->db->where('id', $projectId);
        $query = $this->db->get($this->t_projects);
        log_debug('[project][model][get_project_data] Get rows: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            return $query->row_array(0);
        }
        return null;
    }


    /**
     * Get project's list by user id
     *
     * @param    int
     * @return   array
     */
    public function getProjectsByUserId($userId)
    {
        $this->db->select('id, title, cover_img, school, grade, likes, watches, project_type, created_at, updated_at');
        $this->db->where('uid', $userId);
        $query = $this->db->get($this->t_projects);
        log_debug('[project][model][get_projects_by_user_id] Get rows: ' . $query->num_rows());
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * Get project's list by grade
     *
     * @param    int
     * @return   array
     */
    public function getProjectsByGrade($grade)
    {
        $this->db->where('grade', $grade);
        $query = $this->db->get($this->t_projects);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }


    /**
     * Get project's list by school
     *
     * @param    int
     * @return   array
     */
    public function getProjectsBySchool($schoolId)
    {
        $this->db->where('grade', $schoolId);
        $query = $this->db->get($this->t_projects);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }




}
