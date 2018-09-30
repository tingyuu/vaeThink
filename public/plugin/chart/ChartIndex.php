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
namespace plugin\chart;
use vae\controller\PluginBase;

class ChartIndex extends PluginBase
{
    public $explain = [
        'name'        => 'Chart',
        'hook'        => 'admin_main',
        'title'       => '自定义后台首页(演示)',
        'desc'        => '自定义后台首页(演示)',
        'author'      => '听雨',
        'interface'   => 0,
    ];

    public function index()
    {
        return $this->share('index');
    }
}