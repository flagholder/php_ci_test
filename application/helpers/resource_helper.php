<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 获取静态资源地址
* 
* @param
* 
* @return
*/
if ( ! function_exists('static_url'))
{
    function static_url($uri = '')
    {
		$CI =& get_instance();
        $static_uri = $CI->config->item('static_url');
        if ($static_uri === false)
            $static_uri = '';

        $url = $uri;
        if ($static_uri)
        {
            $url = $static_uri . ltrim($uri);
        }

        return $url;
    }
}

if (  ! function_exists('selected_header') ){
    
    function selected_header( $select_name , $curr_name ,$tag = 'class="selected"' ){
        if( $select_name == $curr_name ){
            return $tag;
        }else{
            return '';
        }
    }
}

if (! function_exists('passport_url'))
{
    function passport_url($uri = '')
    {
		$CI =& get_instance();
        $passport_uri = $CI->config->item('passport_host');
        if ($passport_uri === false)
            $passport_uri = '';

        $url = $passport_uri . ltrim($uri);
        return $url;
    }
}

if (! function_exists('pay_url'))
{
    function pay_url($uri = '')
    {
		$CI =& get_instance();
        $tmp_uri = $CI->config->item('pay_host');
        if ($tmp_uri === false)
            $tmp_uri = '';

        $url = $tmp_uri . ltrim($uri);
        return $url;
    }
}

if (! function_exists('wap_url'))
{
    function wap_url($uri = '')
    {
		$CI =& get_instance();
        $tmp_uri = $CI->config->item('wap_host');
        if ($tmp_uri === false)
            $tmp_uri = '';

        $url = $tmp_uri . ltrim($uri);
        return $url;
    }
}

if (! function_exists('bbs_url'))
{
    function bbs_url($uri = '')
    {
		$CI =& get_instance();
        $tmp_uri = $CI->config->item('bbs_host');
        if ($tmp_uri === false)
            $tmp_uri = '';

        $url = $tmp_uri . ltrim($uri);
        return $url;
    }
}

if (! function_exists('www_url'))
{
    function www_url($uri = '')
    {
		$CI =& get_instance();
        $tmp_uri = $CI->config->item('www_host');
        if ($tmp_uri === false)
            $tmp_uri = '';

        $url = $tmp_uri . ltrim($uri);
        return $url;
    }
}

