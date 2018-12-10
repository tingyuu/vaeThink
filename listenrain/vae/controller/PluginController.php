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
namespace vae\controller;
use think\App;
use think\Loader;

class PluginController extends ControllerBase
{
    public function index($_plugin, $_controller, $_action)
    {

        $_controller = Loader::parseName($_controller, 1);

        $pluginControllerClass = "plugins\\{$_plugin}\\controller\\{$_controller}Controller";

        $vars = [];
        return App::invokeMethod([$pluginControllerClass, $_action, $vars]);
    }

}