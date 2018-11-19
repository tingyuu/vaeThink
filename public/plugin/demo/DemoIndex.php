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
namespace plugin\demo;
use vae\lib\Plugin;

class DemoIndex extends Plugin
{
    //插件基本配置信息，必须配置
    public $explain = [
        // 插件标识，要和目录名字一致
        'name'        => 'Demo',
        // 实现插件的钩子
        'hook'        => 'admin_main',
        // 插件名字
        'title'       => '插件演示',
        // 插件介绍
        'desc'        => '功能：自定义后台首页',
        // 插件作者
        'author'      => '听雨',
        // 是否需要配置
        'interface'   => 0,
    ];

    //业务逻辑
    public function index($params)
    {
        //渲染view目录下的index模板并赋值
        return $this->share('index',[
            'data' => $this->explain,
        ]);
    }

    //必须实现配置
    public function setConfig()
    {
        return true;
    }

    //必须实现安装
    public function install()
    {
        return true;
    }

    //必须实现卸载
    public function uninstall()
    {
        return true;
    }
}