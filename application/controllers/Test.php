<?php
/**
 * Created by PhpStorm.
 * User: jeshen
 * Date: 2/24/2017
 * Time: 1:21 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
        $this->load->model('test/user_test', '', true);
        $this->user_test->count_users();
        $this->load->view('welcome_message');
    }

    public function viewProfile()
    {
        $this->load->view('auth/profile');
    }

    public function showProject()
    {
        $this->load->view('project/show');
//        $this->load-view('project/show');
    }

    public function uploadProjectCover()
    {
        $config['upload_path'] = FCPATH . $this->config->item('upload_file_path', 'xp_config');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $uploadFileUrl = base_url() . 'uploads/';
        $this->load->library('upload', $config);

        log_debug(sprintf('[test][upload_project_cover] files: %s', print_r($_FILES, true)));

        if ($this->upload->do_upload('file')) {
            $coverImgData = $this->upload->data();
            $coverImgFile = $coverImgData['full_path'];
            log_debug('[test][upload_project_cover] image file name:' . $coverImgFile);
        }
    }
}

