<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 缓存系统Key前缀常量定义定义
 *
 * (详细描述)
 *
 * @copyright Copyright&copy; 2017, xProject
 * @author Jerry Shen
 * @version $Id$
 *
 */

class CKEY
{
    // 注册数量. 
    // key:   regcnt:{ip} 
    // value: {'count', 0, 'update_ts':232333445}
    const REG_COUNT = 'regcnt';

    // Session
    const SESSION = 'sess';

    // 登陆失败次数. 
    // key:   lgnf_{ip}
    // value: {'count': 0, 'update_ts':123449858}
    const LOGIN_FAILED_COUNT = 'lgnf';

    // IP黑名单. {'expired':12345678}
    const IPBLACK = 'ip_black'; 

    // IP白名单.  {'expired':12345678}
    const IPWHITE = 'ip_white';

    // VIP配置信息
    const VIP_CONFIG = 'vipcnf';

    // 渠道信息. {'channel_name':'官网'}
    const CHANNEL = 'ch';

    // 用户名映射uuid {'uuid':123}
    const LOGINNAME = 'lgnm';

    // 用户基本信息 {'passwd':'2233333333333333333333333', 'mobile':'', 
    //              'email':'', 'cert_id':'', 'realname':'', 'nickname':'',
    //              'register_ts':'', 'register_ip':'', 'status':''}
    const BASIC = 'bsc';
    const DETAIL = 'dtl';
    const STATUS = 'ust';

    // 应用信息 {'app_id' => 1, 'app_name' => '敢客联盟', 'app_code' => 'gklm' ....}
    const APPINFO = 'app';

    // app_code到app_id的映射. value: 直接存储app_id
    const APPCODE = 'appcd';
    const APPNAME = 'appnm';

    // 应用点数换算配置 {'point_name' => '金币', 'point_ratio' => 100}
    const APPEXCHANGE = 'appexch';

    // 应用支持的充值渠道 {[{charge_channel=> 1, 'start_ts' => 12345678, 'end_ts' => 23456789}, {}]}
    const APP_CHARGE_CHANNEL = 'appchch';

    // 支付渠道信息
    const CHARGE_CHANNEL = 'cch';

    // 支付渠道下的银行
    const CHARGE_CHANNEL_CHILDREN = 'channel_bank';

    // 支付渠道代码 channel_id
    const CHARGE_CHANNEL_CODE = 'channel_code';

    // 钱包支付密码
    const PAYPWD = 'ppwd';
    // 钱包密码出错次数
    const PAYPWD_ERROR = 'ppwderr';

    // 应用开通充值的区服信息
    // KEY: appocs_{app_id}
    // VALUE: {{app_id}:{}}
    const APP_OPEN_CHARGE_SERVER = 'appocs';

    // 开通充值的所有应用
    // VALUE: {1,2,3,4,5}
    const OPEN_CHARGE_ALL_APP = 'appid_opencharge';

    // 支付渠道费率
    const CHARGE_CHANNEL_FEE_RATE = 'channel_feerate';

    // 钱包限额系统配置
    // KEY: wltsyslmcnf_{client_id}-{paypwdStatus}
    // value: array(pay_wallet_limit_config)
    const WALLET_SYSTEM_LIMIT_CONFIG = 'wltsyslmcnf';

    // 钱包限额用户配置
    // KEY: wltalmcnf_{uuid}
    // VALUE: array(pay_wallet_account_limit_config)
    const WALLET_ACCOUNT_LIMIT_CONFIG = 'wltalmcnf';


    //发邮件使用key
    const MAIL_TOKEN = 'mail_key';
    const PAYPWD_MAIL_TOKEN = 'ppmat';

    //发手机验证码key
    const MOBILE_TOKEN = 'mobile_key';
    const PAYPWD_MOBILE_TOKEN = 'ppmot';

    //短暂封停IP key
    const BAN_ACCOUNT = 'ban_account';

    //发送手机号码限定
    const MOBILE_SEND_CODE_LIMIT = 'mscl';

    //发送手机号码 IP 限定
    const IP_MOBILE_SEND_CODE_LIMIT = 'ip_mscl';

    //账号发送短信条数限定
    const ACCOUNT_SEND_COUNT_LIMIT = 'ascl';

    //手机发送验证码时间
    const MOBILE_SEND_INTERVAL = 'mobile_send_time';

    //自动注册 前3位字母key
    const AUTO_ACCOUNT_LETTER_KEY = 'letter_key';

    //自动注册  前3位字母集合
    const AUTO_ACCOUNT_LETTER_PREFIX = 'letter_prefix';

    //自动注册  账号key
    const AUTO_ACCOUNT_SETS_KEY = 'auto_account_sets';

    //填充账号锁
    const AUTO_ACCOUNT_FILL_RUN_LOCK =  'account_fill_run_lock';

    //获取3位字母序列锁
    const AUTO_ACCOUNT_GET_LETTER_LOCK = 'get_letter_lock';

    //已用掉的3位字母序列
    const AUTO_ACCOUNT_USED_LETTER_SETS = 'used_letter_sets';
    
    //
    const AUTO_ACCOUNT_ISEXIST_KEY = 'auto_account_isexist';

    // NICKNAME TO UUID(memb_nickname)
    const NICKNAME_TO_UUID = 'nk_uuid';

    //绑定邮箱频率key
    const BIND_MAIL_RATE_KEY = 'bm_rate_key';

    //绑定邮箱超过频率次数记录
    const BIND_MAIL_RATE_ERROR_COUNT = 'bmrec';

    //超过绑定邮箱超过频率 发邮件封停时间key
    const BIND_MAIL_RATE_TIME_LIMIT = 'bmrt_limit';

    // 最近登陆的AppId
    const LOGIN_APP = 'lgapp';
    const LOGIN_APP_SERVER = 'lgappi';
    const LOGIN_APP_SERVER_ID = 'lgappids';

    // 充值活动
    const CACLIST   = 'cacl';
    const CACINFO   = 'caci';
    const CACAPPS   = 'caca';
    const CACAWARDS = 'cacaw';

    // 游戏区服信息
    const APP_SERVER_INFO = 'appsi';
    const VIPAWARD = 'vipa';

    // 用户在线状态
    const ONLINE_STATUS = 'aols';
    const ONLINE_STATUS_APP = 'aolsa';

    // 推荐游戏
    const RECOMMEND_APP_IDS = 'ras';
    
    //应用所有列表
    const APP_LIST = 'app_list';
    
    //客服问题
    const ASK_LIST_KEY = 'ask_list_key';
    
    //OAUTH
    const OAUTH_API_MAPPING = 'oauth_api_mapping';
    //限制API访问次数统计
    const OAUTH_API_LIMIT = 'oauth_api_limit_count';
    //api key
    const OAUTH_API = 'oauth_api';
    //绑定UID
    const OAUTH_SESSION = 'oauth_session';
    const OAUTH_ACCESS_TOKENS = 'oauth_access_tokens';
    const OAUTH_API_ACTION = 'oauth_api_action';
    // 189短信access_token
    const SMS_ACCESS_TOKEN = 'oauth_189_access_token';
    //礼包详情
    const GIFT_INFO = 'gift_info';
    //礼包列表
    const GIFT_LIST = 'gift_list';
    //激活码
    const GIFT_ACT_CODE = 'gift_act_code';
    
    const GIFT_ACT_USE_CODE = 'gift_act_use_code';
    //热门礼包
    const GIFT_HOT_CODE = 'gift_hot_code';
    
    //已使用的礼包
    const GIFT_USE_LIST = 'gift_use_list';
    
    //礼包领取量
    const GIFT_TAKE_NUM = 'gift_take_num';
    
    //大家都在抢已使用的礼包
    const GIFT_ALL_USE_LIST = 'gift_all_use_list';
    
    //推广
    const TG_USER = 'tg_user';
}
