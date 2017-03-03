<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Base Class
 *
 * Transaction control
 *
 * @copyright Copyright&copy; 2017, xProject
 * @author Jerry Shen
 * @version 0.1
 *
 */

/**
 * MY_Controller, CI_Controller的子类
 *
 *
 *
 * @property bool $_isXA If it is a XA transaction
 *
 * @author Jerry Shen
 * @package core
 *
 */
class MY_Controller extends CI_Controller
{
    private $_isXA = false;
    protected $uuid = NULL;
    protected $loginname = NULL;
    protected $isLogin = false;

    public function __construct($checkLogin = false)
    {
        parent::__construct();
//        $this->error->set_error(ERR::ERR_OK);
//        $this->loginVerify($checkLogin);
    }


    /**
     * Begin normal transaction
     *
     * @param
     *
     * @return object
     */
    public function transBegin()
    {
        $this->_isXA = false;
        return $this->_transStart();
    }

    /**
     * Begin XA transaction
     *
     * @param
     *
     * @return object
     */
    public function transXABegin()
    {
        $this->_isXA = true;
        return $this->_transStart();
    }

    private function _transStart()
    {
        if (!isset($this->db) OR !is_object($this->db) OR $this->db == NULL) {
            $this->load->database('', false, true);
        }

        if ($this->_isXA) {
            $this->db->trans_xa_begin();
        } else {
            $this->db->trans_begin();
        }

        if ($this->db->_error_number() != 0) {
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return false;
        }

        return true;
    }

    /**
     * Commit transaction
     *
     * @param
     *
     * @return bool
     */
    public function transCommit()
    {
        if ($this->db == NULL) {
            $this->transAbort();
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return false;
        }

        $this->db->trans_commit();
        if ($this->db->_error_number() != 0) {
            $this->transAbort();
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return false;
        }

        return true;
    }

    /**
     * Rollback transaction
     *
     * @param
     *
     * @return bool
     */
    public function transAbort()
    {
        $this->db->trans_rollback();
        if ($this->db->_error_number() != 0) {
            return false;
        }

        return true;
    }


    /**
     * 登陆验证
     * 未登陆跳转到登陆页面，已登陆用户执行操作检查
     *
     * @param bool $checkLogin 是否判断登陆状态
     *
     * @return void
     */
    public function loginVerify($checkLogin)
    {
        if (!$checkLogin) {
            return;
        }

        // 判断IP是否有权限访问
        $this->access->check_ip($this->input->ip_address());

        if ($this->auth->is_login() !== true) {
            if ($this->utility->is_ajax_request()) {
                $this->load->library('json');
                $this->error->set_error(ERR::ERR_AUTH_DENIED);
                $this->json->output_jsonp('', array('retcode' => ERR::ERR_AUTH_DENIED, 'retmsg' => $this->error->error_msg()));
                exit();
            }

            if (current_url() != site_url()) {
                redirect('/auth/login?redurl=' . urlencode(current_url() . $this->build_request(true)), 'refresh');
            }

            redirect('/auth/login', 'refresh');
        } else {
            $this->account_verify();
        }
    }


    function build_request($question_mark = false)
    {
        $get = $this->input->get();
        if (!$get) {
            return '';
        }
        if ($question_mark) {
            return '?' . http_build_query($get);
        }
        return http_build_query($get);
    }
}

class API_Controller extends MY_Controller
{
    protected $callback = '';

    public function __construct($verifySign = false)
    {
        parent::__construct();

        $this->load->library('json');
        $this->callback = $this->input->get_post('callback');

        $this->config->load('api');

        $getParam = $this->input->get();
        $postParam = $this->input->get();
        $param = array();
        if ($getParam && $postParam)
            $param = array_merge($getParam, $postParam);
        else if ($getParam)
            $param = $getParam;
        else if ($postParam)
            $param = $postParam;

        $sign = false;
        if (isset($param['sign']))
            $sign = $param['sign'];
        if ($sign === false) {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN, $sign);
            $this->error->show_text_error();
            exit();
        }
//
        $signSecret = $this->config->config['api_secret'];
        $this->load->library('utility');
        unset ($param['sign']);
        $ret = $this->utility->verify_sign($sign, $signSecret, $param);
        if ($ret !== true) {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN);
            $this->error->show_text_error();
            exit();
        }
    }
}
