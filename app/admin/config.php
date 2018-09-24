<?php
//模块配置文件

return [
	'view_replace_str' => [
		'__ADMIN__'      => '/themes/admin_themes',
	],

	'template'               => [
	    // 模板引擎类型 支持 php think 支持扩展
	    'type'         => 'Think',
	    // 模板路径
	    'view_path'    => 'themes/admin_themes/view/',
	    // 模板后缀
	    'view_suffix'  => 'html',
	],

	'cache'  => [
		//缓存类型
	    'type'   => 'File',
	    //缓存目录
	    'path'   => VAE_ROOT . 'runtime/cache',
	    //前缀
	    'prefix' => '',
	    //有效期0表示永久缓存
	    'expire' => 3600,
	],
];