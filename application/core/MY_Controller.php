<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller基类
 *
 * 事务控制
 *
 * @copyright Copyright&copy; 2017, xProject
 * @author Jerry Shen
 * @version
 *
 */

/**
 * MY_Controller, CI_Controller的子类
 *
 * 详细的功能描述
 *
 * @property bool $_is_xa 是否是XA事务
 *
 * @author Jerry Shen
 * @package core
 *
 */
class MY_Controller extends CI_Controller
{
    private $_is_xa = FALSE;
    protected $_uuid = NULL;
    protected $_loginname = NULL;
    protected $_is_login = false;

    public function __construct($checkLogin = false)
    {
        parent::__construct();
        $this->error->set_error(ERR::ERR_OK);

        $this->checkSDKTokenLogin();

        $this->loginVerify($checkLogin);
    }

    /**
     * 判断链接中的token是否有效
     *
     * @param 类型 $fields 描述
     *
     * @return 类型 描述
     */
    public function checkSDKTokenLogin()
    {
        if ($this->auth->is_login() === true)
        {
            return;
        }

        $this->load->library('user_agent');
        if (! $this->agent->is_mobile())
        {
            //return;
        }

        $token = $this->input->get_post('accesstoken');
        $userInfo = $this->cacheredis->get('oauth_access_tokens:' . $token);
        if (!$userInfo)
        {
            return;
        }
        if (isset($userInfo['client_id'])
            && isset($userInfo['user_id'])
            && isset($userInfo['expires']))
        {
            $expires = $userInfo['expires'];
            if ($expires <= time())
            {
                return;
            }
        }
        else
        {
            return;
        }

        $this->load->library('accountinfo');
        $loginname = $this->accountinfo->uuid_to_loginname($userInfo['user_id']);
        if ($loginname === false)
        {
            $this->error->show_error();
            die();
        }

        $this->auth->setCookie($userInfo['user_id'], $loginname, 0);
    }

    /////////////////////////////////////////////////////
    // 事务控制Begin
    /////////////////////////////////////////////////////
    /**
     * 开始数据库事务
     *
     * @param
     *
     * @return
     */
    public function TransBegin()
    {
        $this->_is_xa = FALSE;
        return $this->_transStart();
    }

    /**
     * 开始分布式数据库事务
     *
     * @param
     *
     * @return
     */
    public function TransXABegin()
    {
        // $this->_is_xa = TRUE;
        $this->_is_xa = FALSE;
        return $this->_transStart();
    }

    private function _transStart()
    {
        if (!isset($this->db) OR !is_object($this->db) OR $this->db == NULL)
        {
            $this->load->database('', FALSE, TRUE);
        }

        if ($this->_is_xa)
        {
            $this->db->trans_xa_begin();
        }
        else
        {
            $this->db->trans_begin();
        }

        if ($this->db->_error_number() != 0)
        {
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 提交数据库事务
     *
     * @param
     *
     * @return bool 成功返回TRUE, 失败返回FALSE
     */
    public function TransCommit()
    {
        if ($this->db == NULL)
        {
            $this->TransAbort();
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return FALSE;
        }

        $this->db->trans_commit();
        if ($this->db->_error_number() != 0)
        {
            $this->TransAbort();
            $this->error->set_error(ERR::ERR_TRANS_FAILED);
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 回滚数据库事务
     *
     * @param
     *
     * @return bool 成功返回TRUE, 失败返回FALSE
     */
    public function TransAbort()
    {
        $this->db->trans_rollback();
        if ($this->db->_error_number() != 0)
        {
            return FALSE;
        }

        return TRUE;
    }
    /////////////////////////////////////////////////////
    // 事务控制End
    /////////////////////////////////////////////////////

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
        if (!$checkLogin)
        {
            return;
        }

        // 判断IP是否有权限访问
        $this->access->check_ip($this->input->ip_address());

        if ($this->auth->is_login() !== true)
        {
            if ($this->utility->is_ajax_request())
            {
                $this->load->library('json');
                $this->error->set_error(ERR::ERR_AUTH_DENIED);
                $this->json->output_jsonp('', array('retcode' => ERR::ERR_AUTH_DENIED, 'retmsg' => $this->error->error_msg()));
                exit();
            }

            if (current_url() != site_url())
            {
                redirect('/login/login?redurl='.urlencode(current_url().$this->build_request(true)), 'refresh');
            }

            redirect('/login/login', 'refresh');
        }
        else
        {
            $this->account_verify();
        }
    }

    /**
     * 已登陆账号执行操作权限检查
     *
     * @param void
     *
     * @return void
     */
    public function account_verify()
    {
        $account = $this->auth->current_account();
        $this->_uuid = $account['uuid'];
        $this->_loginname = $account['loginname'];

        // 判断用户状态, 封停/删除/可疑等状态用户无法操作
        // 判断用户是否能使用service_id
    }

    function build_request($question_mark = false)
    {
        $get = $this->input->get();
        if(!$get) {
            return '';
        }
        if($question_mark) {
            return '?'.http_build_query($get);
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
        if ($sign === false)
        {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN, $sign);
            $this->error->show_text_error();
            exit();
        }
//
        $signSecret = $this->config->config['api_secret'];
        $this->load->library('utility');
        unset ($param['sign']);
        $ret = $this->utility->verify_sign($sign, $signSecret, $param);
        if ($ret !== true)
        {
            $this->error->set_error(ERR::ERR_VERIFY_SIGN);
            $this->error->show_text_error();
            exit();
        }
    }
}
