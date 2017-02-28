<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('log_log'))
{
    function log_log($type, $message, $cls_name = '', $func = '', $line = '')
    {
        if (is_array($message))
        {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        }

        $content = '';
        if ($cls_name)
        {
            $content = $content . '[' . $cls_name . ']';
        }

        if ($func)
        {
            $content = $content . '[' . $func . ']';
        }

        if ($line)
        {
            $content = $content . '[' . $line . ']';
        }

        $content = $content . $message;

        log_message($type, $content);
    }
}

if ( ! function_exists('log_debug'))
{
    function log_debug($message, $cls_name = '', $func = '', $line = '')
    {
        log_log('debug', $message, $cls_name, $func, $line);
    }
}

if ( ! function_exists('log_info'))
{
    function log_info($message, $cls_name = '', $func = '', $line = '')
    {
        log_log('info', $message, $cls_name, $func, $line);
    }
}

if ( ! function_exists('log_error'))
{
    function log_error($message, $cls_name = '', $func = '', $line = '')
    {
        log_log('error', $message, $cls_name, $func, $line);
    }
}
