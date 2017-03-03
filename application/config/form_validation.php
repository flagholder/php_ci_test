<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 公共配置参数验证
 *
 * 自定义函数:callback_{这里定义自己的函数}
 *
 */

$config = array(
    'signup' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ),
        array(
            'field' => 'passconf',
            'label' => 'Password Confirmation',
            'rules' => 'required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required'
        )
    ),
    'login' => array(
        array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'remember',
            'label' => 'Remember me',
            'rules' => 'integer'
        )
    )
);

