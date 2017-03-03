<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 访问控制Library
 *
 * 验证IP是否在黑名单
 * 验证IP是否被封停
 * 验证用户是否被封停
 * 
 * 封停用户
 * 封停IP
 * 维护用户密码错误次数
 * 维护IP下注册用户数
 *
 * @copyright Copyright&copy; 2014, EMAGroup
 * @author wuhuiran
 * @version $Id$
 *
 */


/**
 * 访问控制模块
 *
 *
 * @property 类型 $prop 属性描述
 *
 * @author wuhuiran
 * @package library
 *
 */
class Access 
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * 判断IP的访问权限 
     * 
     * @param string $ip ip_address
     * 
     * @return bool 是否可以访问，true/false
     */
    public function check_ip($ip)
    {
        // TODO 管理端黑白名单功能
        // 判断IP是否在黑名单中
        $expired = $this->CI->cacheredis->get($ip, CKEY::IPBLACK);
        if ($expired !== false && isset($expired['expired']) && $expired['expired'] >= now())
        {
            log_debug(array(
                        'message' => '黑名单验证数据',
                        'expired' => $expired['expired'],
                        'now'     => now()), __CLASS__, __FUNCTION__);
            $this->CI->error->set_error(ERR::ERR_IP_IN_BLACK_LIST);
            return false;
        }

        return true;
    }

    /**
     * 判断当前IP的注册页面是否显示验证码
     * 
     * @param string $ip 要验证的IP地址
     * 
     * @return bool true/false
     */
    public function is_reg_captcha($ip)
    {
        return $this->is_captcha($ip, array(
                    'module' => 'register',
                    'count' => CKEY::REG_COUNT
                    ));
    }

    /**
     * 判断登陆页面是否显示验证码
     * 
     * @param string $ip 登陆IP
     * 
     * @return bool true/false
     */
    public function is_login_captcha($ip, $uuid = '')
    {
        return $this->is_captcha($ip, array(
                    'module' => 'login',
                    'uuid' => $uuid,
                    'count' => CKEY::LOGIN_FAILED_COUNT
                    ));
    }
    
    private function get_login_key ($uuid)
    {
        $ip = $this->CI->input->ip_address();
        if ( !empty ($uuid) )
        {
            return CKEY::LOGIN_FAILED_COUNT. ':' . $uuid.':'.$ip;
        }
        else
        {
            return CKEY::LOGIN_FAILED_COUNT. ':' . $ip;
        }
    }
    
    /**
     * 登陆出错次数记录
     * */
    public function add_login_failure_count($uuid ,$ttl = 0)
    {
        if (empty ($ttl) )
        {  //如果  没有设置时间 那么就取默认值
            $config = $this->CI->config->config['captcha'];
            $ttl = isset($config['login']['expired'] ) ? $config['login']['expired'] : 0;
        }

        $is_inc = $this->CI->cacheredis->increment($this->get_login_key($uuid), 1, $ttl);
        $this->CI->cacheredis->increment($this->get_login_key(''), 1, $ttl);   //设置当前错误次数IP
        $this->login_ban_account($uuid);   // 登陆封禁逻辑

        log_debug(array(
                    'message'   => '增加登陆出错次数',
                    'key'       => $this->get_login_key($uuid),
                    'value'     => $this->CI->cacheredis->get($this->get_login_key($uuid))
                    ), __CLASS__, __METHOD__, __LINE__);
        return $is_inc;
    }
    
    public function get_login_failure_count ($uuid)
    {
        $count = $this->CI->cacheredis->get($this->get_login_key($uuid));
        return isset($count) ? $count : 0;
    }
    
    public function del_login_failure_count ($uuid)
    {
        $this->CI->load->library('Kcaptcha');
        $this->CI->kcaptcha->del_captcha();   //删除验证码
        $this->CI->cacheredis->delete($this->get_login_key('') ); //删除IP
        return $this->CI->cacheredis->delete($this->get_login_key($uuid));
    }

    private function get_access_count($prefix, $ip, $uuid = '')
    {
        $key = '';
        if ($uuid)
        {
            $key = $prefix . ':' . $uuid . ':' . $ip;
        }
        else
        {
            $key = $prefix . ':' . $ip;
        }
        
        $count = $this->CI->cacheredis->get($key);
        return $count;
    }

    /**
     * 判断是否显示验证码的实现 
     * 
     * @param string $ip IP地址
     * @param string $prefix memcached Key前缀
     * 
     * @return bool true/false
     */
    private function is_captcha($ip, $data)
    {
        $uuid = 0;
        if (isset($data['uuid']))
            $uuid = $data['uuid'];
        $prefix = $data['count'];

        $config = $this->CI->config->config['captcha'];
        $cnt = $this->get_access_count($prefix, $ip, $uuid);
        if (! $cnt)
        {
            return false;
        }

        //如果存在这个模块  并且开启了验证
        if (isset($config[$data['module']]) && $config[$data['module']]['is_open'] == true )
        {
            if ($cnt >  $config[$data['module']]['count'] )
            {  //如果次数大于了指定次数将显示验证
                return true;    
            }
        }

        return false;
    }
    
    //验证码验证接口
    public function verify()
    {
        $this->CI->load->library('Kcaptcha');
        $p = array();
        $p['captcha'] = $this->CI->input->get('captcha', true);
        if ($this->CI->kcaptcha->verify($p['captcha']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 
     * 验证码N次后跳转地址
     * @param $uuid  用户id
     * @return string
     * */
    public function login_captcha_localtion($uuid){
        $config = $this->CI->config->config['captcha'];
        if ( isset($config['login']['cap_header']) ){
            if ( $this->get_login_failure_count($uuid)  > $config['login']['cap_header']['count'] ){
                return $config['login']['cap_header']['redurl'];
            }
        }
        return '';
    }
    
    private function get_ban_account_key ($uuid){
        return CKEY::BAN_ACCOUNT . $uuid;
    }
    
    public function login_ban_account ($uuid)
    {
        $config = $this->CI->config->config['captcha'];    //载入验证码配置
        $ban_acc_config = isset($config['login']['ban_account']) ? $config['login']['ban_account'] : '';
        if (!empty($ban_acc_config))
        {    // 封禁账号配置
            if ( $this->get_login_failure_count($uuid) + 1 > $ban_acc_config['count'] )
            {   //如果登陆次数大于了配置的次数,则进行封禁
                if ( !isset($ban_acc_config['expired']) ){  //如果没有找到配置  默认 1个小时
                    $ban_acc_config['expired'] = 3600;
                }
                $time = $ban_acc_config['expired'];
                if ($this->ban_account($uuid,$time))
                { // 封禁        
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * 账号是否被封禁
     * */
    
    public function is_login_ban_account($uuid)
    {
        $acc_key = $this->get_ban_account_key($uuid);
        return $this->CI->cacheredis->get ( $acc_key );
    }
    
    /**
     * 短期封禁账号
     * */
    public function ban_account ($uuid,$ttl=0)
    {
        $acc_key  = $this->get_ban_account_key($uuid);
        $data = array (
            'ban_account' => $uuid
        );
        return $this->CI->cacheredis->save($acc_key, $data, '', $ttl);
    }

    /**
     * 增加ip下注册成功用户数量
     * 
     * @param string $ip IP地址
     * 
     * @return void
     */
    public function add_register_count($ip)
    {
        $is_open = false;
        $config = $this->CI->config->config['captcha'];
        if (isset($config['register']['is_open']) && $config['register']['is_open'])
            $is_open = true;
        if (! $is_open)
            return;

        $ttl = 3600;
        if (isset($config['register']['expired']))
            $ttl = $config['register']['expired'];
        $key = $this->CI->cacheredis->make_key($ip, CKEY::REG_COUNT);
        $this->CI->cacheredis->increment($key, 1, $ttl);
    }

    /**
     * 判断用户访问某服务的权限 
     * 
     * @param int $uuid 用户uuid
     * @param int $service_id 服务编号
     * 
     * @return 类型 描述 
     */
    public function account_check($uuid, $service_id)
    {
    }
}
