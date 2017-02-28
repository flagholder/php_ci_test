<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Utility
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }


    /**
     * 判断请求是否是ajax
     *
     * @param void
     *
     * @return bool true/false
     */
    function is_ajax_request()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return true;
        } elseif (isset($_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $browser_type = array(
                'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-'
            , 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'ipad', 'blackberry', 'meizu',
                'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
                'operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $browser_type) . ")/i", $userAgent)) {
                return true;
            }
            if (isset($_SERVER['HTTP_ACCEPT']) AND $_SERVER['HTTP_ACCEPT'] == "*/*") {
                return true;
            }
        }
        return false;
    }

    /**
     * 判断是否https url
     *
     * @param string $url 请求链接
     *
     * @return bool true/false
     */
    public function is_https($url)
    {
        if ($url && trim($url)) {
            return (strtolower(parse_url($url, PHP_URL_SCHEME))) == 'https' ? true : false;
        }

        return false;
    }

    /**
     * 通过节点路径返回字符串的某个节点值
     *
     * @param string $res_data 资源数据(XML数据)
     * @param string $node 节点路径
     *
     * @return string 节点value
     */
    function get_data_for_xml($res_data, $node)
    {
        if (!$res_data || !trim($res_data))
            return false;

        $xml = simplexml_load_string($res_data);
        $result = $xml->xpath($node);

        while (list(, $node) = each($result)) {
            return $node;
        }
        return false;
    }


    /**
     * 取域名
     *
     */
    public function get_domain($url)
    {
        $search = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';

        preg_match_all($search, $url, $match);

        return isset($match[4][0]) ? $match[4][0] : '';
    }

    /**
     *
     * 生成唯一随机数
     */
    public function gen_uniqid_no()
    {
        return md5(date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8));
    }

}
