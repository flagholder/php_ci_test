<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * emagroup.cn Inc.
 * Copyright (c) 2015 All Rights Reserved.
 *
 * @desc	common help:公用辅助函数集
 *
 * @version	#Id: common_helper.php 2015-05-10
 */


/**
 * @desc 打印变量，用于调试
 * @param mixed $var 被打印的变量
 * @param string $form 打印样式
 * 		'print'-默认，用print_r()来打印，变量的结构一目了然
 * 		'php'-用var_export()来打印，返回的是合法的php代码（可以直接复制打印的内容给变量赋值），
 * 				注意：比较复杂的数据结构，这种模式可能报错
 * 		other用var_dump打印，包括变量的类型和值
 */
if (! function_exists('pr'))
{

    function pr ($var, $form = 'print')
    {
        echo '<pre>';
        if ($form == 'print')
        {
            print_r($var);
        }
        elseif ($form == 'php')
        {
            var_export($var);
        }
        else
        {
            var_dump($var);
        }
        echo '</pre>';
    }
}

/**
 * 按指定宽度截断的字符串
 *
 * @author li.l.sdc
 * @param string  $str		待截取字符串
 * @param integer $width	所需修剪的宽度。多字节字符（如中文汉字）通常是单字节字符（如阿拉伯数字，英文字母）的两倍宽度
 * @param string  $suffix   当字符串被截短的时候，将此字符串添加到截短后的末尾
 * @param boolean $encoding	参数为字符编码。如果省略，则使用内部字符编码
 * @return string
 * @example cutStr('123456', 4) return '1...'
 * 			cutStr('欢迎你', 4,'..') return '欢..'
 * 			cutStr('欢迎你', 4,'...') return '...'
 * 			cutStr('123456', 4, '') return '1234'
 * 			cutStr('123456', 6, '...') return '123456'
 * 			cutStr('1234', 4, '....') return '1234'
 * 			cutStr('12345', 4, '....') return '....'
 *  		cutStr('12345', 4, '.....') return '.....'
 */
if (! function_exists('cutStr'))
{
	function cutStr($str, $width, $suffix = '...', $encoding = null, $start = 0) {
		if (is_null($encoding)) {
			$encoding = mb_internal_encoding();//如果没有设置编码，则使用内部字符编码
		}
		return mb_strimwidth($str, $start, $width, $suffix, $encoding);
	}
}

/**
 * 获取对象属性值，如果不存在，返回默认值
 *
 * @author li.l.sdc
 * @param string  $item		对象属性
 * @param integer $object	对象
 * @param string  $default	默认值
 * @return mixed
 */
if (! function_exists('object_element'))
{
	function object_element($item = '', stdClass $object = null, $default = '')
	{
		if ( ! isset($object->$item) || $object->$item === '')
		{
			return $default;
		}

		return $object->$item;
	}
}


/**
 * 判断对象是否为空
 *
 * @param object $object
 *        	要进行判断的对象
 * @return boolean
 */
if (! function_exists('isEmpty'))
{

    function isEmpty ($object)
    {
  		return $object == new stdClass() ? TRUE : FALSE;
    }
}


/**
 * @desc 获取隐藏部分字段的用户名称
 *
 * @access	public
 * @param int $username 	用户名称
 * @return string
 */
if ( ! function_exists('get_other_username'))
{

    function get_other_username ($username = '')
    {
        if (trim($username) == '')
        {
            return $username;
        }
        elseif (preg_match("/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/",  $username))
        {
            $arr = explode("@", $username);
            return $arr[0];
        }
        elseif (preg_match("/^[0-9]{11}$/", $username))
        {
            return substr($username, 0, 4) . '****' . substr($username, 8, 3);
        }
        else
        {
            return $username;
        }
    }
}


/**
 * @desc 参数链接组合
 *
 * @param null
 * @return null
 */
if (! function_exists('link_url'))
{

    function link_url (array $filter= array() , $key = '' , $val= '' , $url = '')
    {
        
    	if (!empty($key))
    	{
        	$filter[$key] = $val; //原数组信息替换
    	}
    	
        $link_arr = array();
        foreach ($filter as $k => $v)
        {
            $link_arr[] = $k.'='.$v;
        }
        
        $link = implode('&', $link_arr);
        if (empty($url))
        {
            $CI = & get_instance();
            $url = '/'.$CI->router->class.'/'.$CI->router->method;
        }
        
        return $url. ( empty($link) ? '' : '?' . $link );
    }
}

if (! function_exists('base_url'))
{

    function base_url ($url)
    {
		$pos = strpos($url, '?');
        if ($pos !== FALSE)
        {
            $url = substr($url, 0, $pos);
        }
        return $url;
    }
}


if ( ! function_exists('groupTheRet')) {
	/**
	 * @desc 对app返回的查询结果集分组。
	 * @param array $ret 结果集
	 * @example Array
				(
				    [0] => stdClass Object
				        (
				            [key] => key0
				            [data] => data0
				        )
				    [1] => stdClass Object
				        (
				            [key] => key1
				            [data] => data1
				        )
				    [2] => stdClass Object
				        (
				            [key] => key0
				            [data] => data2
				        )
				)
	 * @param string $key 分组字段的键名
	 * @param string $is_multidimensional 分组的结果是否是多维的
	 * @param string $re_index 返回结果是否重新索引，只有$is_multidimensional为真时生效
	 * @return array
	 * @example Array
				(
				    [key0] => Array
				        (
				            [0] => stdClass Object
				                (
				                    [key] => key0
				                    [data] => data0
				                )
				
				            [1] => stdClass Object
				                (
				                    [key] => key0
				                    [data] => data2
				                )
				
				        )
				    [key1] => Array
				        (
				            [0] => stdClass Object
				                (
				                    [key] => key1
				                    [data] => data1
				                )
				
				        )
				)
	* @example Array
				(
					[key0] => stdClass Object
				        (
				            [key] => key0
				            [data] => data0
				        )
				    [key1] => stdClass Object
				        (
				            [key] => key1
				            [data] => data1
				        )
				
				    [key2] => stdClass Object
				        (
				            [key] => key2
				            [data] => data3
				        )
				)
	 */
	function groupTheRet($ret, $key, $is_multidimensional = true, $re_index = true) {
		if (is_array($ret)) {
			$res = array();
			foreach ($ret as $k=> $value) {
				if ($is_multidimensional) {
					if ($re_index) {
						$res[object_element($key,$value)][] = $value;
					} else {
						$res[object_element($key,$value)][$k] = $value;
					}
				} else {
					$res[object_element($key,$value)] = $value;
				}
			}
			if ($is_multidimensional && $re_index) {
				$ret = array_values($res);
			} else {
				$ret = $res;
			}
		}
		return $ret;
	}
}

if ( ! function_exists('format_date')) {
	/**
	 * 格式化时间
	 */
	function format_date($date)
	{
		return Date('Y-m-d H:i:s', strtotime($date));
	}
}


function unicode_encode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name)-1;
    $str = '';
    for($i=0;$i<$len;$i=$i+2)
    {
	    $c = $name[$i];
	    $c2 = $name[$i + 1];
	    if (ord($c) > 0)
	    {    // 两个字节的文字
	    	$str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
	    }
	    else
	    {
	    	$str .= $c2;
	    }
	}
    return $str;
}

function unicode_decode($name)
{
	// 转换编码，将Unicode编码转换成可以浏览的utf-8编码
	$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
	preg_match_all($pattern, $name, $matches);
	if (!empty($matches))
	{
		$name = '';
		for ($j = 0; $j < count($matches[0]); $j++)
		{
		$str = $matches[0][$j];
			if (strpos($str, '\\u') === 0)
			{
				$code = base_convert(substr($str, 2, 2), 16, 10);
				$code2 = base_convert(substr($str, 4), 16, 10);
				$c = chr($code).chr($code2);
				$c = iconv('UCS-2', 'UTF-8', $c);
				$name .= $c;
			}
			else
			{
				$name .= $str;
			}
		}
	}
	return $name;
}


function utfdecode($url) // unicode解码 (测试可行)

{
	preg_match_all('/%u([[:alnum:]]{4})/', $url, $a);
	foreach ($a[1] as $uniord)
	{
		$dec = hexdec($uniord);
		$utf = '';
		if ($dec < 128)
		{
			$utf = chr($dec);
		}
		else if ($dec < 2048)
		{
			$utf = chr(192 + (($dec - ($dec % 64)) / 64));
			$utf .= chr(128 + ($dec % 64));
		}
		else
		{
			$utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
			$utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
			$utf .= chr(128 + ($dec % 64));
		}
		$url = str_replace('%u'.$uniord, $utf, $url);
	}
	return urldecode($url);
}



/*** : 对象转数组
 *
 * @param $obj :
 *                所需要转成数组的对象
 * @return array
 *
 */
function objectToArray($obj = FALSE) {
	if (is_object ( $obj )) {
		$obj = get_object_vars ( $obj );
	}
	return $obj;
}

/**
 * @desc 对controller层来的参数列表进行过滤
 *
 * @access	public
 * @param array $params controller层来的参数列表
 * @param array $default 默认参数列表，并定义了参数范围
 * @param boolean $filter_empty 是否过滤掉null和''
 * @return array 最终参数列表
 */
function filter_params(array $params = array(), array $default = array(), $filter_empty = true) {
	//先求交集，然后合并,最后过滤掉null值，null表示不传这个参数
	$intersect = array_intersect_key($params, $default);
	$merge = array_merge($default, $intersect);
	return $filter_empty ? filter_empty($merge) : $merge;
}
/**
 * @desc 过滤掉参数列表中的null和''
 *
 * @access	public
 * @param array $params 参数列表表
 * @return array 过滤后的参数列表
 */
function filter_empty(array $params = array()) {
	return array_filter($params, '_fiter_param');
}
/**
 * @desc 将参数列表中为null和空字符串的字段过滤掉
 *
 * @access	private
 * @param mixed $value
 * @return boolean
 */
function _fiter_param($value) {
	if (is_null($value)) {
		return false;
	} elseif (is_string($value) && trim($value) == '') {
		return false;
	} elseif (is_array($value) && empty($value)) {
		return false;
	} else {
		return true;
	}
}
/* End of file common_helper.php.php */
/* Location: ./application/helpers/common_helper.php */