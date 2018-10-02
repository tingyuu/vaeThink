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

class ModuleInitHook
{

    public function run(&$param)
    {
        if (!vae_is_installed()) {
            return;
        }

        $module = request()->module();

        $moduleHookPluginsCacheKey = "module_init_hook_plugin_{$module}";
        $moduleHookPlugin = cache($moduleHookPluginsCacheKey);

        if (empty($moduleHookPlugin)) {
            $appHooks = Db::name('hook')->where('module', $module)->column('hook');

            $moduleHookPlugin = Db::name('hook_plugin')->field('hook,plugin')->where('status', 1)
                                ->where('hook', 'in', $appHooks)
                                ->order('order asc')
                                ->select();
            cache($moduleHookPluginsCacheKey, $moduleHookPlugin, 0);
        }

        if (!empty($moduleHookPlugin)) {
            foreach ($moduleHookPlugin as $hookPlugin) {
                Hook::add($hookPlugin['hook'], vae_get_plugin_class($hookPlugin['plugin']));
            }
        }
    }
}