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
        $this->load->config('xp_config', true);

        ini_set('memory_limit', '1024M');
        //HTTP上传文件的开关，默认为ON即是开
        ini_set('file_uploads', 'ON');
        //通过POST、GET以及PUT方式接收数据时间进行限制为90秒 默认值：60
        ini_set('max_input_time', '90000');
        //脚本执行时间就由默认的30秒变为180秒
        ini_set('max_execution_time', '180000');
        //Post变量由2M修改为100M，此值改为比upload_max_filesize要大
        ini_set('post_max_size', '100M');
        //上传文件修改也为100M，和上面这个有点关系，大小不等的关系
        ini_set('upload_max_filesize', '100M');
        //正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
        ini_set('memory_limit', '200M');
    }

    public function index()
    {
        $this->load->view('test/upload_test');
    }

    public function upload()
    {
        $config['upload_path'] = '/Users/skywalker/Dev/php/php-ci-test/uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('files')) {
            $error = array('error' => $this->upload->display_errors());

//            $this->load->view('upload_form', $error);
            print_r($error);
        } else {
            $data = array('link' => base_url('uploads/') . $this->upload->data()['file_name']);
//            $fileUrl = base_url('uploads/').$data['file_name'];
//            $response = new \stdClass();
//            $response->link = $fileUrl;

//            $this->load->view('upload_success', $data);
//            print_r($data);
            header('Content-Type: application/json');
            echo json_encode($data);
//            return $response;
        }
    }

    public function uploadImg()
    {
        $config['upload_path'] = FCPATH . $this->config->item('upload_file_path', 'xp_config');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $uploadFileUrl = base_url() . 'uploads/';
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('files')) {
            $error = array('error' => $this->upload->display_errors());
//            $this->load->view('upload_form', $error);
            print_r($error);

        } else {
            $data = $this->upload->data();

            $img = new Imagick($data['full_path']);
            $img->thumbnailImage(200, 0);
            $thumbImgPath = FCPATH . $this->config->item('upload_file_thumb_path', 'xp_config') . $data['file_name'];
            $img->writeImage($thumbImgPath);

            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $uploadFileUrl . $data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $uploadFileUrl . 'thumb/' . $data['file_name'];
            $info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['file_name'];
            $info->deleteType = 'DELETE';
            $info->error = null;

            $files[] = $info;

            if ($this->input->is_ajax_request()) {
                echo json_encode(array("files" => $files));
            } else {
                echo json_encode(array("files" => $files));
            }
        }

    }
}
