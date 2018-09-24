<?php

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
