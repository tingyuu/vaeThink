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
];