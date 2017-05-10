<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 错误码定义和描述
 *
 * 错误码枚举定义
 * 错误码对应的错误描述
 *
 * @copyright Copyright&copy; 2017, xProject
 * @author Jerry Shen
 * @version $Id$
 *
 */

/**
 * 错误码枚举定义
 *
 * 使用方法:Err::ERR_OK
 *
 *
 * @author Jerry Shen
 * @package library/Include
 *
 */
class ERR
{
    // 系统级错误码
    const ERR_OK = 0;
    const ERR_UNDEFINED = 99999;
    const ERR_AUTH_DENIED = 1000;
    const ERR_TRANS_FAILED = 1001;
    const ERR_INVALID_INPUT = 1002;
    const ERR_DB_OPT = 1014;
    const ERR_UNKNOWN = 1003;
    const ERR_TOKEN = 1004;
    const ERR_URI_REQUEST_FAILED = 1005;
    const ERR_INVALID_REQUEST = 1006;
    const ERR_IP_IN_BLACK_LIST = 1007;
    const PAY_USE_WALLET = 10000;
    const ERR_VERIFY_SIGN = 1008;

    // 账号系统错误码
    const ERR_REGISTER_FAILED = 2001;
    const ERR_REGCHANNEL_NOT_EXIST = 2002;
    const ERR_LOGINNAME_NOT_EXIST = 2003;
    const ERR_CREATE_ACCOUNT = 2004;
    const ERR_LOGINNAME_EXIST = 2005;
    const ERR_GET_UUID = 2006;
    const ERR_INVALID_PASSWD = 2007;
    const ERR_ACCOUNT_DIFFER = 2008;
    const ERR_MOBILE_CHECK_CODE = 2009;
    const ERR_PASSWD_NOT_EXISIT = 2010;
    const ERR_PASSWD_ERROR = 2011;
    const ERR_CARD_ID_EXISIT = 2012;
    const ERR_REAL_NAME_EXISIT = 2013;
    const ERR_CHANGEPASS_NO_EXISIT = 2014;
    const ERR_MAIL_FOMAT_ERROR = 2015;
    const ERR_SEND_MAIL_ERROR = 2016;
    const ERR_MISSING_PARAM = 2017;
    const ERR_PHONE_CHECK_ERR = 2018;
    const ERR_NOT_EXISTS_BIND_MAIL = 2019;
    const ERR_NOT_EXISTS_BIND_PHONE = 2020;
    const ERR_SEND_MAIL_FAILURE = 2021;
    const ERR_SEND_PHONE_CODE_FAILURE = 2022;
    const ERR_NICKNAME_NOT_CHANGE = 2023;
    const ERR_NOT_EXISTS_FINDPWD_TYPE = 2024;
    const ERR_INPUT_MOBILE_FAILURE = 2025;
    const ERR_REPLACE_MOBILE_FAILURE = 2026;
    const ERR_INPUT_EMAIL_FAILURE = 2027;
    const ERR_NOT_EXISTS_REPLACE_TYPE = 2028;
    const ERR_CURR_PASS_NOT_EMPTY = 2029;
    const ERR_ACCOUNT_EXISTS = 2030;
    const ERR_INPUT_BIND_EMAIL_EXISTS = 2031;
    const ERR_PASS_RULES_FAILURE = 2032;
    const ERR_ADDRESS_RULES_FAILUE = 2033;
    const ERR_QQ_FORMAT_FAILUE = 2034;
    const ERR_BIRTHDAY_FORMAT_FAILUE = 2035;
    const ERR_ACCOUNT_WRONGFUL = 2036;
    const ERR_NICKNAME_ILLEGAL = 2037;
    const ERR_QQ_NUMBER_NOT_CHA = 2038;
    const ERR_OVERRUN_LEN = 2039;
    const ERR_PASS_AND_ACCOUNT_SAME = 2040;
    const ERR_IDENTCODE_FAILURE = 2041;
    const ERR_ACCOUNT_BE_BAN = 2042;
    const ERR_SEND_MOBILE_NUMS = 2043;
    const ERR_SEND_MOBILE_EXPIRED = 2044;
    const ERR_MAKED_LETTER_LIST_FAILUE = 2045;
    const ERR_REDIS_MULTI_FAILUE = 2046;
    const ERR_POP_REDIS_FAILUE = 2047;
    const ERR_SET_REDIS_LIST_FAILUE = 2048;
    const ERR_MOBILE_ACCOUNT_EXISTS = 2049;
    const ERR_CHECK_PASSWD_TOKEN_FAILUE = 2050;
    const ERR_CERT_ID_FAILUE = 2051;
    const ERR_CHANGE_CERT_ID_FAILUE = 2052;
    const ERR_CHANGE_CERT_STATUS_FAILIE = 2053;
    const ERR_ACCOUNT_SEND_MOBILE_COUNT = 2054;
    const ERR_NICKNAME_EXIST = 2055;
    const ERR_CHANGE_NICKNAME_EXISTS = 2056;
    const ERR_SEND_BIND_MAIL_RATE = 2057;
    const ERR_NEED_ACCOUNT = 2058;
    const ERR_INVALID_LOGINNAME_STYLE = 2059;
    const ERR_SMS_GET_TOKEN_FAILED = 2060;
    const ERR_UPLOAD_FAILED = 2061;
    const ERR_INVALID_UPLOAD_FILE = 2062;
    const ERR_INVALID_UPLOAD_FILESIZE = 2063;
    const ERR_GIFT_NOT_EXIST = 2064;
    const ERR_GIFT_CODE_NOT_EXIST = 2065;
    const ERR_GIFT_EXPIRED = 2066;
    const ERR_GIFT_NOT_START = 2067;
    const ERR_GIFT_UPDATE_FAILED = 2068;
    const ERR_GIFT_DEL_FAILED = 2069;
    const ERR_GIFT_ADD_FAILED = 2070;
    const ERR_GIFT_ISTAKE = 2071;
    const ERR_CHANNEL_CHILD_IS_EXIST = 2072;
    const ERR_GIFT_HISTORY_FAILE = 2073;

    // 开放平台系统
    const ERR_APP_NOT_EXIST = 3000;//APP不存在
    const ERR_APP_NO_API = 3001;//无接口信息
    const ERR_APP_INVALID_CODE = 3002;//无效的CODE
    const ERR_APP_ACCOUNT_NOT_EXIST = 3003;//用户信息不存在
    const ERR_APP_LOGIN_FAILED = 3004;//登录失败

    const ERR_APP_NO_API_ACTION = 3005;//无授权ACTION
    const ERR_APP_SIGN_VALIDATE_FAILED = 3006;//签名验证失败
    const ERR_APP_GRANT_TOKEN_FAILED = 3007;//生成TOKEN失败
    const ERR_APP_GRANT_CODE_FAILED = 3008;//生成CODE失败
    const ERR_APP_NO_PRIVILEGE = 3009;//无权限
    const ERR_APP_ACCESS_LIMIT = 3010;//访问超出限制
    const ERR_APP_NO_MAPPING = 3011;//无次数限制映射信息
    const ERR_APP_APPID_NO_EXIST = 3012;//app_id不存在
    const ERR_APP_CHECK_TOKEN_FAILED = 3013;//access_token验证失败
    const ERR_APP_UNDEFIND_TYPE = 3014;//未定义的校验类型
    const ERR_APP_NOT_SUPPORT_POST = 3015;//api仅支持https post
    const ERR_DUPLICATE_APP_CODE_OR_NAME = 3016;

    const ERR_APP_INVALID_CLIENT = 3017;//无效的客户端
    const ERR_APP_UNAUTHORIZED_CLIENT = 3018;//未经授权的
    const ERR_APP_REDIRECT_URI_MISMATCH = 3019;//重定向URI丢失或不匹配
    const ERR_APP_INVALID_URI = 3020;//无效的URI
    const ERR_APP_INVALID_TOKEN = 3021;//无效的TOKEN
    const ERR_APP_INVALID_REQUEST = 3022;//无效的REQUEST
    const ERR_APP_UNSUPPORTED_GRANT_TYPE = 3023;//不支持当前GRANT_TYPE
    const ERR_APP_INVALID_SCOPE = 3024;//需要指定一个范围参数
    const ERR_APP_INVALID_GRANT = 3025;//无效的grant
    const ERR_APP_DEVICE_UPDATE_FAILED = 3026;

    const ERR_OAUTH_INVALID_CLIENT = 3027;//无效的客户端
    const ERR_OAUTH_UNAUTHORIZED_CLIENT = 3028;//未授权的客户端
    const ERR_OAUTH_REDIRECT_URI_MISMATCH = 3029;//返回地址缺少参数
    const ERR_OAUTH_INVALID_URI = 3030;//无效的返回地址URI
    const ERR_OAUTH_INVALID_TOKEN = 3031;//无效的TOKEN
    const ERR_OAUTH_INVALID_REQUEST = 3032;//无效的REQUEST
    const ERR_OAUTH_UNSUPPORTED_GRANT_TYPE = 3033;//不支持的GRANT_TYPE
    const ERR_OAUTH_INVALID_SCOPE = 3034;//无效的SCOPE
    const ERR_OAUTH_INVALID_GRANT = 3035;//无效的GRANT
    const ERR_OAUTH_NO_MULTIPLE_URI = 3036;//需要更多的URI
    const ERR_OAUTH_NO_URI = 3037;//无返回地址URI
    const ERR_OAUTH_INVALD_CLIENT_CREDENTIALS = 3038;//无效的客户端凭证
    const ERR_OAUTH_NO_FOUND_CLIENT_CREDENTIALS = 3039;//未能找到客户端凭证
    const ERR_OAUTH_INSUFFICIENT_SCOPE = 3040;//权限等级不够
    const ERR_OAUTH_TOKEN_EXPIRED = 3041;//TOKEN过期
    const ERR_OAUTH_NO_POST = 3042;//生成ACCESS_TOKEN必须是POST方式
    const ERR_OAUTH_SPECIFY_PARAMETER = 3043;//SCOPE需要指定参数
    const ERR_OAUTH_UNSUPPORTED_SCOPE = 3044;//不支持当前SCOPE范围
    const ERR_OAUTH_MISSING_CODE = 3045;//请求缺少CODE参数
    const ERR_OAUTH_AUTHORIZATION_CODE_EXPIRED = 3046;//AUTHORIZATION_CODE过期
    const ERR_OAUTH_REQUEST_MISSING_ASSERTION = 3047;//缺少参数ASSERTION
    const ERR_OAUTH_REQUEST_JWT_FAILED = 3048;//JWT 错误
    const ERR_OAUTH_REQUEST_INVALID_ISS = 3049;//无效的ISS
    const ERR_OAUTH_REQUEST_INVALID_SUBJECT = 3050;//无效的SUBJECT
    const ERR_OAUTH_REQUEST_INVALID_EXPIRATION = 3051;//无效的EXPIRATION
    const ERR_OAUTH_REQUEST_JWT_EXPIRED = 3052;//JWT过期
    const ERR_OAUTH_REQUEST_JWT_EXPIRATION_UNIX_STAMP = 3053;//JWT必须是UNIX_TIME_STAMP
    const ERR_OAUTH_REQUEST_JWT_NOT_BEFORE_TIME = 3054;//JWT不能使用BEFORE_TIME
    const ERR_OAUTH_REQUEST_JWT_BEFORE_TIME_UNIX = 3055;//BEFORE_TIME必须是UNIX_TIME_STAMP
    const ERR_OAUTH_REQUEST_INVALID_AUDIENCE = 3056;//无效的AUDIENCE
    const ERR_OAUTH_REQUEST_INVALID_ISSUER = 3057;//无效的ISSUER
    const ERR_OAUTH_REQUEST_VERIFICATION_SIGN_FAILED = 3058;//验证签名失败
    const ERR_OAUTH_MISSING_USERNAME_PASSWORD = 3059;
    const ERR_OAUTH_INVALID_USERNAME_PASSWORD = 3060;
    const ERR_OAUTH_NOT_USER_INFO = 3061;
    const ERR_OAUTH_ON_METHOD_AUTH_A_TIME = 3062;
    const ERR_OAUTH_ON_METHOD_AUTHHEADER_FAILED = 3063;
    const ERR_OAUTH_METHOD_MUST_POST = 3064;
    const ERR_OAUTH_POST_TYPE_FORM_URLENCODE = 3065;
    const ERR_OAUTH_AUTH_CODE_OR_INVALID_CLIENT = 3066;//Authorization_code 不存在或者无效的客户端
    const ERR_OAUTH_REFRESH_TOKEN_MISS_PARAM = 3067;//缺少参数REFRESH_TOKEN
    const ERR_OAUTH_INVALID_REFRESH_TOKEN = 3068;//无效的REFRESH_TOKEN
    const ERR_OAUTH_REFRESH_TOKEN_EXPIRED = 3069;//REFRESH_TOKEN过期

    const ERR_OAUTH_SESSION_VALIDATE_FAILED = 3070;
    const ERR_OAUTH_SESSION_NOT_EXIST = 3071;


    // 支付系统错误码
    const ERR_NO_POINT_EXCHANGE = 4000;
    const ERR_CHARGE_CHANNEL_NOT_EXIST = 4001;
    const ERR_APP_CHARGE_NOT_OPEN = 4002;
    const ERR_POINT_EXCHANGE = 4003;
    const ERR_CHARGE_AMOUNT_NOT_MATCH = 4004;
    const ERR_CHARGE_CHANNEL_UNSUPPORT = 4005;
    const ERR_NEED_OUT_ORDER_ID = 4006;
    const ERR_DUP_OUT_ORDER_ID = 4007;
    const ERR_ORDER_NOT_EXIST = 4008;
    const ERR_DUP_PAY_TRADE_ID = 4009;
    const ERR_ORDER_STATUS_P = 4010;
    const ERR_ORDER_STATUS_S = 4011;
    const ERR_ORDER_STATUS_T = 4012;
    const ERR_INVALID_PAY_AMOUNT = 4013;
    const ERR_TRADE_NOT_EXIST = 4014;
    const ERR_PAY_ORDER_NOT_EXIST = 4016;
    const ERR_INCORRECT_PAY_PWD = 4017;
    const ERR_WALLET_BALANCE_NOT_ENOUGH = 4018;
    const ERR_WALLET_ACCOUNT_NOT_EXIST = 4019;
    const ERR_WALLET_STATUS_ERROR = 4020;
    const ERR_WALLET_FROZEN_FAILED = 4021;
    const ERR_FROZEN_AMOUNT_NOT_ENOUGH = 4022;
    const ERR_WALLET_NO_PASSWD = 4023;
    const ERR_PAY_SIGN_VERIFY_FAILED = 4024;
    const ERR_INVALID_PAY_RESULT = 4025;
    const ERR_INVALID_PAY_INPUT = 4026;
    const ERR_PAY_RESULT_FAILED = 4027;
    const ERR_JF_CALC_FAILED = 4028;
    const ERR_WALLET_LIMIT_CHECK_FAILED = 4029;
    const ERR_OVER_WALLET_IN_AMOUNT = 4030;
    const ERR_OVER_WALLET_OUT_AMOUNT = 4031;
    const ERR_OVER_WALLET_TIMES = 4032;
    const ERR_MUST_USE_WALLET_PWD = 4033;
    const ERR_OVER_WALLET_SINGLE_AMOUNT = 4034;
    const ERR_UPDATE_WALLET_LIMIT_STATUS_FAILED = 4035;
    const ERR_MONEY_IS_NOT_INT = 4036;
    const ERR_MONEY_THAN_QUOTA = 4037;
    const ERR_WALLET_LIMIT_EMPTY = 4038;
    const ERR_CREATE_ORDER = 4039;
    const ERR_MONEY_LESS_THAN_QUOTA = 4040;
    const ERR_NO_POING_EXCHANGE = 4041;
    const ERR_DUPLICATE_CHARGE_CHANNEL_NAME_OR_CODE = 4042;
    const ERR_DUPLICATE_APP_SERVER_NAME = 4043;
    const ERR_WALLET_BAN = 4044;
    const ERR_MUST_LOGIN_WHEN_USE_WALLET = 4045;
    const ERR_INVALID_CARDINFO = 4046;
    const ERR_PAY_CARD_REQUEST_FAILED = 4047;
    const ERR_APP_SERVER_NOT_EXIST = 4048;
    const ERR_CHARGE_CHANNEL_FEE_SET_NOT_EXIST = 4049;
    const ERR_NO_WALLET_PWD_INPUT = 4050;
    const ERR_NO_CHARGE_CHANNEL_SELECTED = 4051;
    const ERR_CREATE_PRODUCT_ORDER = 4052;
    const ERR_ORDER_PRODUCT_NOT_EXIST = 4053;
    const ERR_WAP_TOKEN_ID_NOT_EXIST = 4054;

    //File upload
    const ERR_UPLOAD_FILE_FAILED = 6000;
    const ERR_UPLOAD_FILE_READ_FAIL = 6001;
    const ERR_UPLOAD_SAVE_CROP_FILE_FAIL = 6002;
    const ERR_UPLOAD_CROP_IMG_FAIL = 6003;
}


/**
 * 错误码对应的错误描述
 *
 * 使用方法:ErrMessage::$arErrCode[ERR::ERR_OK]
 *
 * @author wuhuiran
 * @package library/Include
 *
 */
class ErrMessage
{
    public static $arErrCode = array(
        ERR::ERR_OK => 'success',
        ERR::PAY_USE_WALLET => 'success',
        ERR::ERR_AUTH_DENIED => 'Permission Denied!',
        ERR::ERR_TRANS_FAILED => '系统异常，请联系管理员(Error:1002)',
        ERR::ERR_INVALID_INPUT => '非法的参数',
        ERR::ERR_DB_OPT => '数据库错误',
        ERR::ERR_UNKNOWN => 'Unknown',
        ERR::ERR_URI_REQUEST_FAILED => 'URI请求失败',
        ERR::ERR_INVALID_REQUEST => '非法的请求',
        ERR::ERR_VERIFY_SIGN => '验签失败',

        ERR::ERR_REGISTER_FAILED => '注册失败',
        ERR::ERR_REGCHANNEL_NOT_EXIST => '注册渠道不存在',
        ERR::ERR_LOGINNAME_NOT_EXIST => '用户不存在',
        ERR::ERR_CREATE_ACCOUNT => '创建账号失败',
        ERR::ERR_LOGINNAME_EXIST => '用户名已存在',
        ERR::ERR_GET_UUID => '获取UUID失败',
        ERR::ERR_INVALID_PASSWD => '用户密码错误',
        ERR::ERR_APP_NOT_EXIST => '应用不存在',
        ERR::ERR_NO_POINT_EXCHANGE => '点数换算信息不存在',
        ERR::ERR_CHARGE_CHANNEL_NOT_EXIST => '支付渠道不存在',
        ERR::ERR_APP_CHARGE_NOT_OPEN => '应用未开放充值',
        ERR::ERR_POINT_EXCHANGE => '点数换算错误',
        ERR::ERR_CHARGE_AMOUNT_NOT_MATCH => '支付金额不匹配',
        ERR::ERR_CHARGE_CHANNEL_UNSUPPORT => '应用不支持给定支付渠道',
        ERR::ERR_NEED_OUT_ORDER_ID => '第三方订单号不能为空',
        ERR::ERR_DUP_OUT_ORDER_ID => '重复的第三方订单号',
        ERR::ERR_ORDER_NOT_EXIST => '订单不存在',
        ERR::ERR_DUP_PAY_TRADE_ID => '重复的第三方支付系统订单号',
        ERR::ERR_ORDER_STATUS_P => '订单处理中',
        ERR::ERR_ORDER_STATUS_S => '订单已完成',
        ERR::ERR_ORDER_STATUS_T => '订单已关闭',
        ERR::ERR_INVALID_PAY_AMOUNT => '支付金额不合法',
        ERR::ERR_TRADE_NOT_EXIST => '订单号不存在',
        ERR::ERR_PAY_ORDER_NOT_EXIST => '支付记录不存在',
        ERR::ERR_ACCOUNT_DIFFER => '账户类型不一致',
        ERR::ERR_MOBILE_CHECK_CODE => '短信验证码错误',
        ERR::ERR_PASSWD_NOT_EXISIT => '密码或确认密码不能为空',
        ERR::ERR_PASSWD_ERROR => '两次密码不相等',
        ERR::ERR_CARD_ID_EXISIT => '身份证号不能为空',
        ERR::ERR_REAL_NAME_EXISIT => '真实姓名不能为空',
        ERR::ERR_INCORRECT_PAY_PWD => '钱包支付密码错误',
        ERR::ERR_WALLET_BALANCE_NOT_ENOUGH => '钱包余额不足',
        ERR::ERR_WALLET_ACCOUNT_NOT_EXIST => '钱包帐户不存在',
        ERR::ERR_WALLET_STATUS_ERROR => '钱包状态错误',
        ERR::ERR_CHANGEPASS_NO_EXISIT => '修改密码不能为空',
        ERR::ERR_MAIL_FOMAT_ERROR => '邮箱格式不正确',
        ERR::ERR_SEND_MAIL_ERROR => '邮件发送失败',
        ERR::ERR_TOKEN => '验证码错误',
        ERR::ERR_MISSING_PARAM => '缺少参数',
        ERR::ERR_PHONE_CHECK_ERR => '手机格式不正确',
        ERR::ERR_WALLET_FROZEN_FAILED => '钱包冻结失败',
        ERR::ERR_FROZEN_AMOUNT_NOT_ENOUGH => '钱包冻结金额不足',
        ERR::ERR_WALLET_NO_PASSWD => '为了你的资金安全，请设置钱包支付密码<br><a href="https://passport.emagroup.cn/account?page=6&step=2">设置钱包支付密码</a>',
        ERR::ERR_PAY_SIGN_VERIFY_FAILED => '验签失败',
        ERR::ERR_INVALID_PAY_RESULT => '非法的支付结果',
        ERR::ERR_NICKNAME_NOT_CHANGE => '昵称已存在不能被修改',
        ERR::ERR_SEND_PHONE_CODE_FAILURE => '发送手机验证码失败',
        ERR::ERR_SEND_MAIL_FAILURE => '发送邮箱失败',
        ERR::ERR_NOT_EXISTS_BIND_PHONE => '未绑定手机',
        ERR::ERR_NOT_EXISTS_BIND_MAIL => '未绑定邮箱',
        ERR::ERR_NOT_EXISTS_FINDPWD_TYPE => '不存在的找回方式',
        ERR::ERR_INPUT_MOBILE_FAILURE => '输入的绑定号码不正确',
        ERR::ERR_REPLACE_MOBILE_FAILURE => '替换绑定手机失败',
        ERR::ERR_INPUT_EMAIL_FAILURE => '输入的email不正确',
        ERR::ERR_INVALID_PAY_INPUT => '非法的支付系统输入参数',
        ERR::ERR_PAY_RESULT_FAILED => '支付结果失败',
        ERR::ERR_NOT_EXISTS_REPLACE_TYPE => '不存在的替换方式',
        ERR::ERR_CURR_PASS_NOT_EMPTY => '当前密码不能为空',
        ERR::ERR_IP_IN_BLACK_LIST => '对不起,你的IP在黑名单中',
        ERR::ERR_ACCOUNT_EXISTS => '该账号已被注册',
        ERR::ERR_INPUT_BIND_EMAIL_EXISTS => '输入的绑定邮箱不正确',
        ERR::ERR_PASS_RULES_FAILURE => '输入密码不符合密码规则',
        ERR::ERR_ADDRESS_RULES_FAILUE => '输入的地址规则不正确',
        ERR::ERR_QQ_FORMAT_FAILUE => 'QQ格式不正确',
        ERR::ERR_BIRTHDAY_FORMAT_FAILUE => '日期格式错误',
        ERR::ERR_ACCOUNT_WRONGFUL => '账号名不合法',
        ERR::ERR_NICKNAME_ILLEGAL => '请输入20个字符以内的昵称',
        ERR::ERR_BIRTHDAY_FORMAT_FAILUE => '日期格式错误',
        ERR::ERR_JF_CALC_FAILED => '积分计算失败',
        ERR::ERR_QQ_NUMBER_NOT_CHA => '亲QQ号不能是中文',
        ERR::ERR_OVERRUN_LEN => '超出允许长度',
        ERR::ERR_MONEY_IS_NOT_INT => '请输入正确的数字金额',
        ERR::ERR_MONEY_THAN_QUOTA => '输入的金额不能大于9999',
        ERR::ERR_MONEY_LESS_THAN_QUOTA => '输入的金额不能小于1',
        ERR::ERR_APP_ACCOUNT_NOT_EXIST => '用户信息不存在',
        ERR::ERR_APP_LOGIN_FAILED => '登录失败',
        ERR::ERR_APP_SIGN_VALIDATE_FAILED => '签名验证失败',
        ERR::ERR_APP_GRANT_TOKEN_FAILED => '生成TOKEN失败',
        ERR::ERR_APP_GRANT_CODE_FAILED => '生成CODE失败',
        ERR::ERR_WALLET_LIMIT_CHECK_FAILED => '<div style="text-align:left">您已超出钱包每日支付限额，您可以尝试：<br> 1. 选择其他支付方式<br> 2. 设置钱包密码可以<a href="https://passport.lemonade-game.com/account?page=6">修改支付限额</a></div>',
        ERR::ERR_OVER_WALLET_IN_AMOUNT => '超出每日钱包充入金额',
        ERR::ERR_OVER_WALLET_OUT_AMOUNT => '已超出每日钱包支出金额',
        ERR::ERR_OVER_WALLET_TIMES => '已超出每日钱包可用次数',
        ERR::ERR_MUST_USE_WALLET_PWD => '必须使用钱包密码',
        ERR::ERR_OVER_WALLET_SINGLE_AMOUNT => '超出钱包单笔最大金额',
        ERR::ERR_UPDATE_WALLET_LIMIT_STATUS_FAILED => '更新钱包支付限额状态失败',
        ERR::ERR_PASS_AND_ACCOUNT_SAME => '账号和密码不能相同',
        ERR::ERR_APP_NO_PRIVILEGE => '无权限访问',
        ERR::ERR_APP_ACCESS_LIMIT => '访问次数超出限制',
        ERR::ERR_APP_NO_MAPPING => '无映射次数信息',
        ERR::ERR_IDENTCODE_FAILURE => '验证码错误',
        ERR::ERR_ACCOUNT_BE_BAN => '账号已被封禁',
        ERR::ERR_PASS_AND_ACCOUNT_SAME => '账号和密码不能相同',
        ERR::ERR_SEND_MOBILE_NUMS => '您已达到今天发送的最大限量',
        ERR::ERR_SEND_MOBILE_EXPIRED => '请稍后再发',
        ERR::ERR_MAKED_LETTER_LIST_FAILUE => '生成字母列表出错',
        ERR::ERR_REDIS_MULTI_FAILUE => 'redis事务启动失败',
        ERR::ERR_SET_REDIS_LIST_FAILUE => '设置redis列表失败',
        ERR::ERR_POP_REDIS_FAILUE => '获取redis列表失败',
        ERR::ERR_WALLET_LIMIT_EMPTY => '钱包限额不能为空',
        ERR::ERR_CREATE_ORDER => '创建订单失败',
        ERR::ERR_MOBILE_ACCOUNT_EXISTS => '该手机号码已被绑定',
        ERR::ERR_CHECK_PASSWD_TOKEN_FAILUE => '认证失败,无法重置密码',
        ERR::ERR_CERT_ID_FAILUE => '请输入正确的身份证号码',
        ERR::ERR_CHANGE_CERT_ID_FAILUE => '更新身份证号码错误',
        ERR::ERR_CHANGE_CERT_STATUS_FAILIE => '更新身份证状态错误',
        ERR::ERR_ACCOUNT_SEND_MOBILE_COUNT => '您已达到今天发送的最大限量',
        ERR::ERR_NICKNAME_EXIST => '昵称不存在',
        ERR::ERR_SEND_BIND_MAIL_RATE => '操作过于频繁,请稍后再试',
        ERR::ERR_CHANGE_NICKNAME_EXISTS => '昵称已存在,换一个昵称试试吧',
        ERR::ERR_APP_NO_API => 'API未被绑定授权访问',
        ERR::ERR_APP_INVALID_CODE => '无效的AUTH_CODE',
        ERR::ERR_APP_NO_API_ACTION => '无授权API_ACTION',
        ERR::ERR_APP_APPID_NO_EXIST => 'APPID不存在',
        ERR::ERR_APP_CHECK_TOKEN_FAILED => 'ACCESS_TOKEN验证失败',
        ERR::ERR_APP_UNDEFIND_TYPE => '未定义的检验类型',
        ERR::ERR_APP_NOT_SUPPORT_POST => 'API仅支持HTTPS_POST',
        ERR::ERR_NO_POING_EXCHANGE => '没有找到点数换算配置',
        ERR::ERR_DUPLICATE_APP_CODE_OR_NAME => '重复的应用名称或代码',
        ERR::ERR_DUPLICATE_CHARGE_CHANNEL_NAME_OR_CODE => '重复的支付渠道名称或代码',
        ERR::ERR_DUPLICATE_APP_SERVER_NAME => '重复的服务器名称',
        ERR::ERR_WALLET_BAN => '<div style="text-align:left">您输入错误密码次数过多，为保证您的财产安全我们将暂时锁定您的钱包。您可以进行如下操作:<br>1. <a href="https://pay.lemonade-game.com/paysecure/findpwd">找回钱包密码</a><br>2. 使用其他支付方式支付</div>',
        ERR::ERR_MUST_LOGIN_WHEN_USE_WALLET => '使用钱包支付时必须登录！请登录后重试。',
        ERR::ERR_INVALID_CARDINFO => '卡信息错误！<br>请确认卡号、卡密输入正确',
        ERR::ERR_PAY_CARD_REQUEST_FAILED => '支付失败！<br>卡号不存在或已被使用',
        ERR::ERR_APP_SERVER_NOT_EXIST => '游戏大区不存在',
        ERR::ERR_CHARGE_CHANNEL_FEE_SET_NOT_EXIST => '支付渠道费率设置不存在',
        ERR::ERR_NO_WALLET_PWD_INPUT => '请输入钱包密码',
        ERR::ERR_NEED_ACCOUNT => '当前操作必须指定用户',
        ERR::ERR_INVALID_LOGINNAME_STYLE => '用户名格式不正确',
        ERR::ERR_SMS_GET_TOKEN_FAILED => 'SMS获取ACCESS_TOKEN失败',
        ERR::ERR_NO_CHARGE_CHANNEL_SELECTED => '当前应用没有选择支付方式, 无法完成支付',
        ERR::ERR_CREATE_PRODUCT_ORDER => '创建订单商品信息失败',
        ERR::ERR_ORDER_PRODUCT_NOT_EXIST => '订单商品信息不存在',

        ERR::ERR_APP_DEVICE_UPDATE_FAILED => '同步设备信息失败',
        ERR::ERR_FORM_FILE_NOT_CONFIG => '表单中上传域名设置不正确',
        ERR::ERR_OAUTH_INVALID_CLIENT => '无效的客户端',
        ERR::ERR_OAUTH_UNAUTHORIZED_CLIENT => '未授权的客户端',
        ERR::ERR_OAUTH_REDIRECT_URI_MISMATCH => '缺少返回地址参数',
        ERR::ERR_OAUTH_INVALID_URI => '无效的返回地址URI',
        ERR::ERR_OAUTH_INVALID_TOKEN => '无效的TOKEN',
        ERR::ERR_OAUTH_INVALID_REQUEST => '无效的REQUEST',
        ERR::ERR_OAUTH_UNSUPPORTED_GRANT_TYPE => '不支持的GRANT_TYPE',
        ERR::ERR_OAUTH_INVALID_SCOPE => '无效的SCOPE',
        ERR::ERR_OAUTH_INVALID_GRANT => '无效的GRANT',
        ERR::ERR_OAUTH_NO_MULTIPLE_URI => '需要更多的URI',
        ERR::ERR_OAUTH_NO_URI => '无返回地址URI',
        ERR::ERR_OAUTH_INVALD_CLIENT_CREDENTIALS => '无效的客户端凭证',
        ERR::ERR_OAUTH_NO_FOUND_CLIENT_CREDENTIALS => '未能找到客户端凭证',
        ERR::ERR_OAUTH_INSUFFICIENT_SCOPE => '权限等级不够',
        ERR::ERR_OAUTH_TOKEN_EXPIRED => 'TOKEN过期',
        ERR::ERR_OAUTH_NO_POST => '生成ACCESS_TOKEN必须是POST方式',
        ERR::ERR_OAUTH_SPECIFY_PARAMETER => 'SCOPE需要指定参数',
        ERR::ERR_OAUTH_UNSUPPORTED_SCOPE => '不支持当前SCOPE范围',
        ERR::ERR_OAUTH_MISSING_CODE => '请求缺少CODE参数',
        ERR::ERR_OAUTH_AUTHORIZATION_CODE_EXPIRED => 'AUTHORIZATION_CODE过期',
        ERR::ERR_OAUTH_REQUEST_MISSING_ASSERTION => '缺少参数ASSERTION',
        ERR::ERR_OAUTH_REQUEST_JWT_FAILED => 'JWT 错误',
        ERR::ERR_OAUTH_REQUEST_INVALID_ISS => '无效的ISS',
        ERR::ERR_OAUTH_REQUEST_INVALID_SUBJECT => '无效的SUBJECT',
        ERR::ERR_OAUTH_REQUEST_INVALID_EXPIRATION => '无效的EXPIRATION',
        ERR::ERR_OAUTH_REQUEST_JWT_EXPIRED => 'JWT过期',
        ERR::ERR_OAUTH_REQUEST_JWT_EXPIRATION_UNIX_STAMP => 'JWT必须是UNIX_TIME_STAMP',
        ERR::ERR_OAUTH_REQUEST_JWT_NOT_BEFORE_TIME => 'JWT不能使用BEFORE_TIME',
        ERR::ERR_OAUTH_REQUEST_JWT_BEFORE_TIME_UNIX => 'BEFORE_TIME必须是UNIX_TIME_STAMP',
        ERR::ERR_OAUTH_REQUEST_INVALID_AUDIENCE => '无效的AUDIENCE',
        ERR::ERR_OAUTH_REQUEST_INVALID_ISSUER => '无效的ISSUER',
        ERR::ERR_OAUTH_REQUEST_VERIFICATION_SIGN_FAILED => '验证签名失败',
        ERR::ERR_OAUTH_MISSING_USERNAME_PASSWORD => '缺少用户账号和密码',
        ERR::ERR_OAUTH_INVALID_USERNAME_PASSWORD => '无效的用户名和密码',
        ERR::ERR_OAUTH_NOT_USER_INFO => '无用户信息',
        ERR::ERR_OAUTH_ON_METHOD_AUTH_A_TIME => '只能验证一次',
        ERR::ERR_OAUTH_ON_METHOD_AUTHHEADER_FAILED => '验证header失败',
        ERR::ERR_OAUTH_METHOD_MUST_POST => '方法必须是post',
        ERR::ERR_OAUTH_POST_TYPE_FORM_URLENCODE => '请求格式必须是application/x-www-form-urlencoded',
        ERR::ERR_OAUTH_AUTH_CODE_OR_INVALID_CLIENT => 'Authorization_code不存在或无效的客户端',
        ERR::ERR_OAUTH_REFRESH_TOKEN_MISS_PARAM => '缺少参数REFRESH_TOKEN',
        ERR::ERR_OAUTH_INVALID_REFRESH_TOKEN => '无效的REFRESH_TOKEN',
        ERR::ERR_OAUTH_REFRESH_TOKEN_EXPIRED => 'REFRESH_TOKEN过期',
        ERR::ERR_OAUTH_SESSION_VALIDATE_FAILED => 'SESSIONID验证失败',
        ERR::ERR_OAUTH_SESSION_NOT_EXIST => 'SESSIONID信息不存在',
        ERR::ERR_UPLOAD_FAILED => '上传文件失败',
        ERR::ERR_INVALID_UPLOAD_FILE => '文件不符合规则',
        ERR::ERR_INVALID_UPLOAD_FILESIZE => '上传的文件过大',
        ERR::ERR_GIFT_NOT_EXIST => '礼包不存在',
        ERR::ERR_GIFT_CODE_NOT_EXIST => '礼包激活码不存在',
        ERR::ERR_GIFT_EXPIRED => '礼包已过期',
        ERR::ERR_GIFT_NOT_START => '礼包还未开始',
        ERR::ERR_GIFT_UPDATE_FAILED => '修改礼包失败',
        ERR::ERR_GIFT_HISTORY_FAILE => '添加推广礼包信息记录失败',
        ERR::ERR_GIFT_DEL_FAILED => '删除礼包失败',
        ERR::ERR_GIFT_ADD_FAILED => '添加礼包失败',
        ERR::ERR_GIFT_ISTAKE => '已经领取过该礼包了',
        ERR::ERR_WAP_TOKEN_ID_NOT_EXIST => 'WAP_TOKEN_ID无效',
        ERR::ERR_CHANNEL_CHILD_IS_EXIST => '包含子渠道',

    );
}
