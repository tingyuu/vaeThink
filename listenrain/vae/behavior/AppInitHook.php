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
use think\db\Query;
use think\Hook;
use think\Db;

class AppInitHook
{
	public function run(&$params){ 
        //\think\Session::delete('vae_admin');  
		if (!vae_is_installed()) {
            return;
        }

        $appHookPlugin = cache('app_init_hook_plugin');
        if (empty($appHookPlugin)) {
            $hook = Db::name('hook')->where('type', 1)->column('hook');

            $appHookPlugin = Db::name('hook_plugin')->field('hook,plugin')->where('status', 1)
                            ->where('hook', 'in', $hook)
                            ->order('order asc')
                            ->select();
            cache('app_init_hook_plugin', $appHookPlugin, 0);
        }

        if (!empty($appHookPlugin)) {
            foreach ($appHookPlugin as $hookPlugin) {
                Hook::add($hookPlugin['hook'], vae_get_plugin_class($hookPlugin['plugin']));
            }
        }
    }
}