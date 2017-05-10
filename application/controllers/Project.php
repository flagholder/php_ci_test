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
        parent::__construct(true);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('xp_project');
    }

    public function index()
    {
        $this->showMyProject();
    }

    public function create()
    {
        $this->load->view('project/create');
    }

    public function submit()
    {
        $redurl = $this->input->get_post('redurl') ? $this->input->get_post('redurl') : site_url('home/');
        $title = $this->input->post('title') ?? '';
        $startAt = $this->input->post('start_at') ?? '';
        $endAt = $this->input->get_post('end_at') ?? '';
        $grade = $this->input->get_post('grade') ?? '0';
        $content = $this->input->get_post('content') ?? '';

        log_info(
            sprintf(
                '[project][submit] title=%s, start_at=%s, end_at=%s, grade=%s, content=%s ',
                $title,
                $startAt,
                $endAt,
                $grade,
                $content
            )
        );

//        TODO: validate input
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('start_at', 'Start Time', 'trim|required');
        $this->form_validation->set_rules('end_at', 'End Time', 'trim|required');
        $this->form_validation->set_rules('grade', 'Grade', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');

        $validateResult = $this->form_validation->run();

        $data['errors'] = array();
        if ($validateResult) {
            $data = $this->xp_project->createProject(
                $this->userInfo['id'],
                $this->form_validation->set_value('title'),
                $this->form_validation->set_value('start_at'),
                $this->form_validation->set_value('end_at'),
                $this->form_validation->set_value('grade'),
                $this->form_validation->set_value('content')
            );

            if (!is_null($data)) {
                $this->load->view('project/show');
            } else {
                $this->load->view('project/create');
            }
        } else {
            print('validation fail');
        }
    }

    public function showMyProject()
    {
        $data = array(
            'errors' => null,
            'records' => null
        );
        $records = $this->xp_project->getProjectsByUserId($this->userInfo['id']);
        log_debug('[project][C][showMyProject] get projects :' . $records[0]['title']);
        if (is_null($records)) {
            $data['errors'] = 'Get projects by user ID failed';
        } else {
            $data['records'] = $records;
        }
        $this->load->view('project/show', $data);
    }

    public function viewProject()
    {
        $data = array(
            'errors' => null,
            'contents' => null
        );

        $projectId = $this->input->get_post('pid') ?? 0;
        if ($projectId == 0) {
            $data['errors'] = 'Project ID is invalid';
        } else {
            $contents = $this->xp_project->viewProject($this->userInfo['id'], $projectId);
            if (is_null($contents)) {
                $data['errors'] = 'Get project error';
            } else {
                $data['contents'] = $contents;
            }
        }

        $this->load->view('project/view_project', $data);
    }

}
