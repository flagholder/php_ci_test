<?php

/**
 * Xp_upload
 *
 * File upload library
 *
 * @package     Project
 * @author      Jerry Shen
 * @version     0.1
 * @license     X-Projects Copyright (c) 2017
 */
class Xp_upload
{
    private $error = array('err_code' => ERR::ERR_UNDEFINED, 'err_msg' => '');


    public function __construct()
    {
        $this->ci =& get_instance();
        require_once('Include/define.inc.php');
        $this->ci->load->config('xp_config', true);
        $this->ci->load->database();
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * Crop an image
     * @param   int
     * @param   str
     * @param   str
     * @param   array
     * @return  array
     */
    public function crop($type, $src, $dst, $data)
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
                $this->error['err_code'] = ERR::ERR_UPLOAD_FILE_READ_FAIL;
                $this->error['err_msg'] = 'Failed to read the image file';
                return $this->error;
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
                    '[upload][%s] dst_img=%s, src_img=%s, $dst_x=%s, dst_y=%s, src_x=%s, src_y=%s, dst_w=%s, dst_h=%s, src_w=%s, src_h=%s ',
                    basename(__FILE__),
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
                    $this->error['err_code'] = ERR::ERR_UPLOAD_SAVE_CROP_FILE_FAIL;
                    $this->error['err_msg'] = 'Failed to save the cropped image file';
                    return $this->error;
                }
            } else {
                $this->error['err_code'] = ERR::ERR_UPLOAD_CROP_IMG_FAIL;
                $this->error['err_msg'] = 'Failed to crop the image file';
                return $this->error;
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);

            $this->error['err_code'] = ERR::ERR_OK;
            return $this->error;
        } else {
            $this->error['err_code'] = ERR::ERR_INVALID_INPUT;
            return $this->error;
        }
    }
}
