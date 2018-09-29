<?php

namespace app\admin\validate;

use think\Validate;

class Conf extends Validate
{
    protected $rule = [
        'title'              => 'require',
        'admin_title'        => 'require',
        'smtp'               => 'require',
        'username'           => 'require',
        'password'           => 'require',
        'port'               => 'require',
        'email'              => 'require',
        'from'               => 'require',
    ];

    protected $message = [
        'title.require'              => '网站标题不能为空',
        'admin_title.require'        => '后台标题不能为空',
        'smpt.require'               => 'SMTP服务器地址不能为空',
        'username.require'           => '邮箱账户不能为空',
        'password.require'           => '密码不能为空',
        'port.require'               => '端口不能为空',
        'email.require'              => '发送者邮箱不能为空',
        'from.require'               => '要显示的发送者信息不能为空',
    ];

    protected $scene = [
        'webConf' => ['title', 'admin_title'],
        'emailConf' => ['smtp', 'username', 'password', 'port', 'email', 'from'],
    ];
}