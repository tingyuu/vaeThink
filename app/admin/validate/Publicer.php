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
use think\Db;

class Publicer extends Validate
{
    protected $rule = [
        'username'       => 'require',
        'password'       => 'require',
        'captcha'        => 'require|captcha',
    ];

    protected $message = [
        'username.require'       => '用户名不能为空',
        'password.require'       => '密码不能为空',
        'captcha.require'        => '验证码不能为空',
        'captcha.captcha'        => '验证码不正确',
    ];
}