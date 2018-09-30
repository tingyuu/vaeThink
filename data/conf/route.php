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

// 应用路由

use think\Db;
use think\Cache;
use think\Route;

if(Cache::get('vae_route')) {
	$runtimeRoute = Cache::get('vae_route');
} else {
	$runtimeRoute = Db::name("route")->where(['status' => 1])->order('create_time asc')->column('url,full_url');
	Cache::set('vae_route',$runtimeRoute);
}

Route::rule($runtimeRoute);
