<?php
namespace plugin\chart;
use vae\controller\PluginBase;

class ChartIndex extends PluginBase
{
    public $info = [
        'name' => 'chart',
    ];

    public function index()
    {
        return $this->share('index');
    }
}