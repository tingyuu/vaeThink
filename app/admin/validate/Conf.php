<?php
// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +---------------------------------------------------------------------
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
        'appkey'             => 'require',
        'secretkey'          => 'require',
        'FreeSignName'       => 'require',
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
        'appkey.require'             => 'appkey不能为空',
        'secretkey.require'          => 'secretkey不能为空',
        'FreeSignName.require'       => '签名不能为空',
    ];

    protected $scene = [
        'webConf' => ['title', 'admin_title'],
        'emailConf' => ['smtp', 'username', 'password', 'port', 'email', 'from'],
        'dayuConf' => ['appkey', 'secretkey', 'FreeSignName'],
    ];
}