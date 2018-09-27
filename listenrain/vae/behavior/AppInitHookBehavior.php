<?php
namespace vae\behavior;
use think\db\Query;
use think\Hook;
use think\Db;

class AppInitHookBehavior {

	public function run(&$params){   
		if (!vae_get_login_admin()) {
            return;
        }

        $systemHookPlugins = cache('init_hook_plugins_system_hook_plugins');
        if (empty($systemHookPlugins)) {
            $systemHooks = Db::name('hook')->column('hook');

            $systemHookPlugins = Db::name('hook_plugin')->field('hook,plugin')->where('status', 1)
                ->where('hook', 'in', $systemHooks)
                ->order('order asc')
                ->select();
            cache('init_hook_plugins_system_hook_plugins', $systemHookPlugins, null, 'init_hook_plugins');
        }

        if (!empty($systemHookPlugins)) {
            foreach ($systemHookPlugins as $hookPlugin) {
                Hook::add($hookPlugin['hook'], vae_get_plugin_class($hookPlugin['plugin']));
            }
        }
    }
}