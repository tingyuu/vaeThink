<?php
// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +----------------------------------------------------------------------
namespace plugin\hacker;
use vae\controller\PluginBase;

class HackerIndex extends PluginBase
{
    public $explain = [
        'name'        => 'Hacker',
        'hook'        => 'admin_login',
        'title'       => '黑客后台登录页',
        'desc'        => '自定义黑客风格后台登录页',
        'author'      => '听雨',
        'interface'   => 0,
    ];

    public function index()
    {
        return $this->share('index');
    }
}