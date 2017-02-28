<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Log library use Sealog
 *
 * @package		Log
 * @author		wuhuiran
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @data        2014-10-10
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Logging Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * @author		wuhuiran
 * @link		http://codeigniter.com/user_guide/general/errors.html
 */
class CI_Log {

    protected $_log_path;
    protected $_threshold	= 1;
    protected $_date_fmt	= 'Y-m-d H:i:s';
    protected $_enabled	= TRUE;
    protected $_levels	= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');

    /**
     * Constructor
     */
    public function __construct()
    {
        $config =& get_config();

        $this->_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';

        if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))
        {
            $this->_enabled = FALSE;
        }

        if ( function_exists('seaslog_get_version'))
        {
            SeasLog::setBasePath($this->_log_path);
        }

        if (is_numeric($config['log_threshold']))
        {
            $this->_threshold = $config['log_threshold'];
        }

        if ($config['log_date_format'] != '')
        {
            $this->_date_fmt = $config['log_date_format'];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Write Log File
     *
     * Generally this function will be called using the global log_message() function
     *
     * @param	string	the error level
     * @param	string	the error message
     * @param	bool	whether the error is a native PHP error
     * @return	bool
     */
    public function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }

        $level = strtoupper($level);

        if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
        {
            return FALSE;
        }

        // extension_loaded('seaslog') &&
        if ( function_exists('seaslog_get_version'))
        {
            switch ($this->_levels[$level])
            {
                case 1: // ERROR
                    SeasLog::error($msg);
                    break;
                case 2: // DEBUG
                    SeasLog::debug($msg);
                    break;
                case 3: // INFO
                    SeasLog::info($msg);
                    break;
                default:
                    break;
            }
        }
        else
        {
            $filepath = $this->_log_path.'log-'.date('Y-m-d').'.php';
            $message  = '';

            if ( ! file_exists($filepath))
            {
                $message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
            }

            if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
            {
                return FALSE;
            }

            $message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

            flock($fp, LOCK_EX);
            fwrite($fp, $message);
            flock($fp, LOCK_UN);
            fclose($fp);

            @chmod($filepath, FILE_WRITE_MODE);
        }

        return TRUE;
    }
    
    /**
     * 通用日志方法
     * 
     * @param $level 日志级别
     * @param $message 
     * @param array $content
     * @param string $module
     */
    public function write($level,$message,$content,$module = '')
    {
        return SeasLog::log($level,$message,$content,$module);
    }
}
// END Log Class

/* End of file Log.php */
