<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 错误码
 *
 * 详细的功能描述（可略）
 *
 * @copyright Copyright&copy; 2014, 柠檬水
 * @author ${AUTHOR}
 * @version  $Id: ${FILE_NAME}, v ${VERSION} ${TIME} ${AUTHOR} Exp $
 *
 */
class Error
{
    private $CI;
    private $_error_code = null;
    private $_error_msg = null;

    function __construct($config = array())
    {
        require_once 'Include/error.inc.php';
        $this->CI =& get_instance();
    }

    /**
     * 返回错误码
     *
     * @param
     *
     * @return int 当前instance的错误码
     */
    function error_code()
    {
        return $this->_error_code;
    }

    /**
     * 设置错误码
     *
     * @param int $error_code 错误码
     *
     * @return void
     */
    function set_error($error_code, $error_msg = '')
    {
        $argv = func_get_args();
        $this->_error_code = $error_code;
        if ($error_msg) {
            $this->_error_msg = $error_msg;
        } else {
            $this->_error_msg = call_user_func_array(array($this, 'error_msg'), $argv);
        }
    }

    /**
     * 判断调用是否失败
     *
     * @param
     *
     * @return bool 当前无错误返回TRUE, 否则返回FALSE
     */
    function error()
    {
        if ($this->_error_code != 0) {
            return true;
        }
        return false;
    }

    /**
     * 获取错误码对应的错误信息
     *
     * @param int $error_code [可选]错误码
     *
     * @return string 错误码对应的错误描述
     */
    function error_msg($error_code = null)
    {
        $argv = func_get_args();
        if ($error_code === null) {
            return $this->_error_msg;
        }
        if (!isset(ErrMessage::$arErrCode[$error_code])) {
            $argv[0] = '未定义的错误码：[' . $error_code . ']';
        } else {
            $argv[0] = ErrMessage::$arErrCode[$error_code];
        }
        return call_user_func_array('sprintf', $argv);
    }

    //展现成功提示页
    function show_success($error_msg = null)
    {
        if ($error_msg == null) {
            $error_msg = $this->error_msg();
        }
        $this->CI->load->library('utility');
        if ($this->CI->utility->is_ajax_request()) {
            $data = array(
                'retcode' => '0',
                'retmsg' => 'success'
            );
            $this->CI->load->library('json');
            $this->CI->json->output_jsonp('', $data);
        } else {
            ob_start();
            $this->CI->template->set('main_page', 'hidden');
            $buffer = $this->CI->template->load('default', 'error/success', array('error_msg' => $error_msg), true);
            ob_end_clean();
            echo $buffer;
        }
    }

    //展现错误页
    function show_error($error_msg = null)
    {
        if ($error_msg == null) {
            $error_msg = $this->error_msg();
        }

        $this->CI->load->library('utility');
        if ($this->CI->utility->is_ajax_request()) {
            $data = array(
                'retcode' => $this->error_code(),
                'retmsg' => $this->error_msg()
            );
            $this->CI->load->library('json');
            $this->CI->json->output_jsonp('', $data);
        } else {
            ob_start();
            $buffer = $this->CI->load->view('error/error', array('error_msg' => $error_msg), true);
            ob_end_clean();
            echo $buffer;
        }
    }

    /**
     * 展示文本错误信息
     *
     * @param string $error_msg 错误描述
     *
     * @return void
     */
    function show_text_error($error_msg = null)
    {
        if ($error_msg == null) {
            $error_msg = $this->error_msg();
        }

        $this->CI->load->library('utility');
        if (!$this->CI->utility->is_ajax_request()) {
            $data = array(
                'retcode' => $this->error_code(),
                'retmsg' => $this->error_msg()
            );
            $this->CI->load->library('json');
            $this->CI->json->output_jsonp('', $data);
        } else {
            echo $error_msg;
        }
    }

    /**
     * API
     * @param string $error_msg 自定义错误描述
     * @param array $arr_data 待返回结果集
     * @param string $callback 回调地址
     *
     */
    function error_json($error_msg = null, $arr_data = array(), $callback = '')
    {
        if ($error_msg == null) {
            $error_msg = $this->error_msg();
        }
        $default_data = array(
            'errno' => $this->error_code(),
            'errmsg' => $error_msg,
        );

        $data = array_merge($default_data, $arr_data);
        $this->CI->load->library('json');
        $this->CI->json->output_jsonp($callback, $data);
    }

    //获取所有错误码列表
    function error_list()
    {
        return ErrMessage::$arErrCode;
    }
}
