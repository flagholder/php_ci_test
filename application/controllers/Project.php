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
        return;
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
        $data = null;
        $this->xp_project->getProjectByUserId($this->userInfo['id']);
        $this->load->view('project/show', $data);
    }

}
