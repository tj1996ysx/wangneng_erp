<?php

$config = array(
    'api_user_login'	=>	array(
        array(
            'field'	=>	'username',
            'label'	=> '用户名称',
            'rules'	=> 'required',
            'errors' => array(
                'required' => '%s不能为空',
            ),
        ),
        array(
            'field'	=>	'passwd',
            'label'	=> '登录密码',
            'rules'	=> 'required',
            'errors' => array(
                'required' => '%s不能为空',
            ),
        ),
    ),
);