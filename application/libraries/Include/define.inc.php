<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 业务常量数据定义
 *
 *
 *
 * @copyright Copyright&copy; 2017, xProject
 * @author Jerry Shen
 * @version $Id$
 *
 */

class DEF
{
    const DEFAULT_EXPIRE_TS = 3600;
    // 一小时
    const TIME_HOUR = 3600;

    // EMA站点client_id
    const EMA_CLIENT_ID = 1000;
    
    // API发送验证码
    const EXPIRE_TIME = 600;

    // 默认生成账号个数
    const GENERAT_NUM = 100;

    // HTTP 400
    const BAD_REQUEST = 400;
    // HTTP 401
    const UNAUTHORIZED = 401;


    //同步设备信息
    //状态(R-注册/L-登陆)
    const DEVICE_LOGIN_STATUS = 'L';
    const DEVICE_REGISTER_STATUS = 'R';

    // User status
    const USER_STATUS_NOT_ACTIVATED  = '1';
    const USER_STATUS_ACTIVATED      = '2';
    const USER_STATUS_BANNED         = '3';


}
