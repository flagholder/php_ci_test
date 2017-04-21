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
 * MY_Controller, subclass of CI_Controller
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
    protected $isXA = false;
    protected $userInfo = array (
        'id' => null,
        'email' => null,
        'username' => null
    );
    protected $uuid = null;
    protected $loginname = null;
    protected $isLogin = false;

    public function __construct($checkLogin = false)
    {
        parent::__construct();
//        $this->error->set_error(ERR::ERR_OK);
//        $this->loginVerify($checkLogin);

        if ($checkLogin) {
            $this->load->library('xp_auth');
            $this->lang->load('auth');
            if ($this->loginVerify()) {
                $this->userInfo = $this->xp_auth->getUserInfo();
            }
        }
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
        $this->isXA = false;
        return $this->transStart();
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
        $this->isXA = true;
        return $this->transStart();
    }

    private function transStart()
    {
        if (!isset($this->db) or !is_object($this->db) or $this->db == null) {
            $this->load->database('', false, true);
        }

        if ($this->isXA) {
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
        if ($this->db == null) {
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
     *
     * @return boolean
     */
    public function loginVerify()
    {
        // 判断IP是否有权限访问
//        $this->access->check_ip($this->input->ip_address());

        $loginStatus = $this->xp_auth->isLogin();

        if ($loginStatus === DEF::USER_STATUS_BANNED) {
            $this->load->view('errors/error_message');
        } elseif ($loginStatus === DEF::USER_STATUS_NOT_ACTIVATED) {
            redirect(base_url('auth/send_again/'));
        } elseif ($loginStatus === DEF::USER_STATUS_ACTIVATED) {
            // TODO: Can add more account check at here
            return true;
        } else {
            if (current_url() != site_url()) {
                redirect(base_url('auth/login?redurl=' . urlencode(current_url() . $this->buildRequest(true)), 'refresh'));
            }
        }
        return false;


//        if ($this->auth->is_login() !== true) {
//            if ($this->utility->is_ajax_request()) {
//                $this->load->library('json');
//                $this->error->set_error(ERR::ERR_AUTH_DENIED);
//                $this->json->output_jsonp('', array('retcode' => ERR::ERR_AUTH_DENIED, 'retmsg' => $this->error->error_msg()));
//                exit();
//            }
//
//            if (current_url() != site_url()) {
//                redirect('/auth/login?redurl=' . urlencode(current_url() . $this->build_request(true)), 'refresh');
//            }
//
//            redirect('/auth/login', 'refresh');
//        }
    }


    public function buildRequest($questionMark = false)
    {
        $get = $this->input->get();
        if (!$get) {
            return '';
        }
        if ($questionMark) {
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
        if ($getParam && $postParam) {
            $param = array_merge($getParam, $postParam);
        } elseif ($getParam) {
            $param = $getParam;
        } elseif ($postParam) {
            $param = $postParam;
        }

        $sign = false;
        if (isset($param['sign'])) {
            $sign = $param['sign'];
        }
        if ($sign === false) {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN, $sign);
            $this->error->show_text_error();
            exit();
        }
//
        $signSecret = $this->config->config['api_secret'];
        $this->load->library('utility');
        unset($param['sign']);
        $ret = $this->utility->verify_sign($sign, $signSecret, $param);
        if ($ret !== true) {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN);
            $this->error->show_text_error();
            exit();
        }
    }
}
