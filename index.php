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

// [ 应用入口文件 ]

// 定义vaeThink当前版本号
define('VAE_VERSION','1.0.2');

// 定义Layui版本号
define('LAYUI_VERSION','2.4.5');

// 定义应用目录
define('APP_PATH', __DIR__ . '/../app/');

// 定义vaeThink项目目录
define('VAE_ROOT', __DIR__ . '/../');

// 定义插件目录
define('PLUGIN_PATH', VAE_ROOT . 'plugin/');

// 定义vaeThink核心包目录
define('VAE_LTR', VAE_ROOT . 'listenrain/vae/');

// 定义配置文件目录
define('CONF_PATH', VAE_ROOT.'data/conf/');

// 定义应用的运行目录
define('RUNTIME_PATH', VAE_ROOT . 'data/runtime/');

// 加载ThikPHP引导文件
require VAE_ROOT . 'listenrain/thinkphp/base.php';

// 执行应用
\think\App::run()->send();