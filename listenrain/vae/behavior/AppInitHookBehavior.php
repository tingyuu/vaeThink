<?php
namespace vae\behavior;
use think\db\Query;
use think\Hook;
use think\Db;

class AppInitHookBehavior {

	public function run(&$params){   
		if (!vae_get_login_admin()) {
            return true;
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