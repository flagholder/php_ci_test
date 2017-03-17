<?php

/**
 * Created by PhpStorm.
 * User: skywalker
 * Date: 3/16/17
 * Time: 9:47 PM
 */
class Upload extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        return;
    }

    public function upload()
    {
        $config['upload_path']      = '/Users/skywalker/Dev/php/php-ci-test/uploads/';
        $config['allowed_types']    = 'gif|jpg|png';
        $config['max_size']         = 10000;
        $config['max_width']        = 10240;
        $config['max_height']       = 7680;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());

//            $this->load->view('upload_form', $error);
            print_r($error);
        } else {
            $data = array('link' => base_url('uploads/').$this->upload->data()['file_name']);
//            $fileUrl = base_url('uploads/').$data['file_name'];
//            $response = new \stdClass();
//            $response->link = $fileUrl;

//            $this->load->view('upload_success', $data);
//            print_r($data);
            header('Content-Type: application/json');
            echo json_encode( $data );
//            return $response;
        }
    }

}
