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
namespace vae\behavior;
use think\Loader;
use think\App;

class AppInitRute
{
    public function run(&$param)
    {
        if (!vae_is_installed()) {
            return;
        }

        $urlStr = request()->url();
        $urlArray = explode('/',$urlStr);
        if($urlArray[1] === 'plugin') {

            if(count($urlArray) < 5) {
                return vae_assign(0,'非法请求');
            }

            $plugin = $urlArray[2];
            $controller = Loader::parseName($urlArray[3], 1);
            $action = $urlArray[4];

            $pluginControllerClass = "plugin\\{$plugin}\\controller\\{$controller}Controller";

            App::invokeMethod([$pluginControllerClass, $action, []]);
            die;
        }
    }
}