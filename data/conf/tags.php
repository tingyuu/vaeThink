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

// 应用行为扩展定义文件
return [
    // 应用初始化
    'app_init'     => [
        'vae\\behavior\\AppInitHook',
    ],
    // 应用开始
    'app_begin'    => [
        'vae\\behavior\\AppInitRute',
    ],
    // 模块初始化
    'module_init'  => [
        'vae\\behavior\\ModuleInitHook',
    ],
    // 操作开始执行
    'action_begin' => [],
    // 视图内容过滤
    'view_filter'  => [],
    // 日志写入
    'log_write'    => [],
    // 应用结束
    'app_end'      => [],
    // admin模块开始
    'admin_init'   => [
        'vae\\behavior\\AdminCheckAuth',
    ],
];
