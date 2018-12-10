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
namespace vae\lib;

abstract class Plugin extends \think\Controller
{
    protected function _initialize()
    {
        parent::_initialize();
    }

    public function run(&$params)
    {
        return $this->index($params);
    }

    // 调用模板及渲染数据
    protected function share($template, $data=[])
    {
        $template = 'view/'.$template;
        $explain = $this->explain;
        $templateConf = [
            // 模板引擎类型 支持 php think 支持扩展
            'type'         => 'Think',
            // 模板路径
            'view_path'    => PLUGIN_PATH.strtolower($explain['name'])."/",
            // 模板后缀
            'view_suffix'  => 'html',
            // 模板文件名分隔符
            'view_depr'    => DS,
            // 模板引擎普通标签开始标记
            'tpl_begin'    => '{',
            // 模板引擎普通标签结束标记
            'tpl_end'      => '}',
            // 标签库标签开始标记
            'taglib_begin' => '{',
            // 标签库标签结束标记
            'taglib_end'   => '}',
        ];
        return $this->engine($templateConf)->fetch($template, $data);
    }

    protected function config($key='')
    {
        $explain = $this->explain;
        $config = include PLUGIN_PATH.strtolower($explain['name'])."/".$explain['name'].'Config.php';
        if(!empty($key)) {
            $config = $config[$key];
        }
        return $config;
    }

    //必须实现配置
    abstract public function setConfig();

    //必须实现安装
    abstract public function install();

    //必须实现卸载
    abstract public function uninstall();
}