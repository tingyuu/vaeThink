<?php
namespace plugin\chart;
use vae\controller\PluginBase;

class ChartIndex extends PluginBase
{
    public $explain = [
        'name'        => 'Chart',
        'title'       => '自定义后台首页(演示)',
        'desc'        => '自定义后台首页(演示)',
        'author'      => '听雨',
        'conf'        => 0,
    ];

    public function index()
    {
        return $this->share('index');
    }
}