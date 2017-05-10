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
        parent::__construct(true);
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
        $config['upload_path'] = FCPATH . $this->config->item('upload_file_path', 'xp_config');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
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

    public function uploadAvatar()
    {
        $config['upload_path'] = FCPATH . $this->config->item('upload_avatar_src_path', 'xp_config');
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name'] = true;
        $config['max_size'] = 10240; // 10MB
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $this->load->library('upload', $config);

        $srcFile = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
        $avatarData = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
        $avatarFile = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
        log_debug('[upload][avatar] avatar_data=' . $avatarData);

        if (!empty($avatarData)) {
            $avatarData = json_decode(stripslashes($avatarData));
        }

        if (!$this->upload->do_upload('avatar_file')) {
            $error = array('error' => $this->upload->display_errors());
//            $this->load->view('upload_form', $error);
            log_debug('[upload][avatar_upload] upload avatar file:' . $error);

        } else {
            $data = $this->upload->data();

            $imgType = exif_imagetype($data['full_path']);
            $src = $data['full_path'];
            $dstFileName = $this->userInfo['id'] . '_' .date('YmdHis') . '.png';
            $dst = FCPATH . $this->config->item('upload_avatar_path', 'xp_config') . $dstFileName;
            $result = $this->crop($imgType, $src, $dst, $avatarData);
            log_debug('[upload][avatar_upload] save and crop avatar result: ' . $result);

            $srcUrl = base_url() . 'uploads/avatar/src/' . $data['file_name'];
            $dstUrl = base_url() . 'uploads/avatar/' . $dstFileName;
            $showImg = !empty($avatarData) ? $dstUrl : $srcUrl;

            $dbResult = $this->xp_auth->updateUserAvatar($this->userInfo['id'], $dstUrl);
            if ($dbResult) {
                $response = array(
                    'state' => 200,
                    'message' => $result,
                    'result' => $showImg
                );
            } else {
                $response = array(
                    'state' => 500,
                    'message' => 'update database error',
                    'result' => ''
                );
            }

            echo json_encode($response);
        }
    }


    public function uploadProjectCover()
    {
        $config['upload_path'] = FCPATH . $this->config->item('upload_project_img_src_path', 'xp_config');
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name'] = true;
        $config['max_size'] = 10240; // 10MB
        $config['max_width'] = 10240;
        $config['max_height'] = 7680;

        $this->load->library('upload', $config);

        $srcFile = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
        $avatarData = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
        $avatarFile = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
        log_debug('[upload][project_cover] avatar_data=' . $avatarData);

        if (!empty($avatarData)) {
            $avatarData = json_decode(stripslashes($avatarData));
        }

        if (!$this->upload->do_upload('avatar_file')) {
            $error = array('error' => $this->upload->display_errors());
//            $this->load->view('upload_form', $error);
            log_debug('[upload][project_cover] upload project cover :' . $error);

        } else {
            $data = $this->upload->data();

            $imgType = exif_imagetype($data['full_path']);
            $src = $data['full_path'];
            $dstFileName = $this->userInfo['id'] . '_' .date('YmdHis') . '.png';
            $dst = FCPATH . $this->config->item('upload_avatar_path', 'xp_config') . $dstFileName;
            $result = $this->crop($imgType, $src, $dst, $avatarData);
            log_debug('[upload][avatar_upload] save and crop avatar result: ' . $result);

            $srcUrl = base_url() . 'uploads/avatar/src/' . $data['file_name'];
            $dstUrl = base_url() . 'uploads/avatar/' . $dstFileName;
            $showImg = !empty($avatarData) ? $dstUrl : $srcUrl;

            $dbResult = $this->xp_auth->updateUserAvatar($this->userInfo['id'], $dstUrl);
            if ($dbResult) {
                $response = array(
                    'state' => 200,
                    'message' => $result,
                    'result' => $showImg
                );
            } else {
                $response = array(
                    'state' => 500,
                    'message' => 'update database error',
                    'result' => ''
                );
            }

            echo json_encode($response);
        }
    }

    private function crop($type, $src, $dst, $data)
    {
        $msg = '';

        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($type) {
                case IMAGETYPE_GIF:
                    $src_img = imagecreatefromgif($src);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = imagecreatefromjpeg($src);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = imagecreatefrompng($src);
                    break;

                default:
                    $src_img = null;
            }

            if (!$src_img) {
                $msg = "Failed to read the image file";
                return $msg;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data->rotate;

            // Rotate the source image
            if (is_numeric($degrees) && $degrees != 0) {
                // PHP's degrees is opposite to CSS's degrees
                $new_img = imagerotate($src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127));

                imagedestroy($src_img);
                $src_img = $new_img;

                $deg = abs($degrees) % 180;
                $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                // Fix rotated image miss 1px issue when degrees < 0
                $src_img_w -= 1;
                $src_img_h -= 1;
            }

            $tmp_img_w = $data->width;
            $tmp_img_h = $data->height;
            $dst_img_w = 200;
            $dst_img_h = 200;

            $src_x = $data->x;
            $src_y = $data->y;

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } elseif ($src_x <= 0) {
                $dst_x = -$src_x;
                $src_x = 0;
                $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
            } elseif ($src_x <= $src_img_w) {
                $dst_x = 0;
                $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } elseif ($src_y <= 0) {
                $dst_y = -$src_y;
                $src_y = 0;
                $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
            } elseif ($src_y <= $src_img_h) {
                $dst_y = 0;
                $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
            }

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            log_info(
                sprintf(
                    '[upload][avatar][crop] dst_img=%s, src_img=%s, $dst_x=%s, dst_y=%s, src_x=%s, src_y=%s, dst_w=%s, dst_h=%s, src_w=%s, src_h=%s ',
                    $dst_img,
                    $src_img,
                    $dst_x,
                    $dst_y,
                    $src_x,
                    $src_y,
                    $dst_w,
                    $dst_h,
                    $src_w,
                    $src_h
                )
            );

            $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

            if ($result) {
                if (!imagepng($dst_img, $dst)) {
                    $msg = "Failed to save the cropped image file";
                }
            } else {
                $msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);

            return $msg;
        }
    }
}
