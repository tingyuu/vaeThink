<?php
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;
use app\admin\model\Plugin as PluginModel;

class Plugin extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getPluginList()
    {
        $pluginModel = new PluginModel;
        $plugins = $pluginModel->getPlugin();
        return vae_assign(0,'',$plugins);
    }

    //禁用
    public function disabled()
    {
        $name =  vae_get_param('name');
        \think\Db::name('HookPlugin')->where(['plugin'=>$name])->update(['status'=>0]);
        cache('module_init_hook_plugin_admin',null);
        return vae_assign(1,'禁用成功');
    }

    //启用
    public function start()
    {
        $name =  vae_get_param('name');
        \think\Db::name('HookPlugin')->where(['plugin'=>$name])->update(['status'=>1]);
        cache('module_init_hook_plugin_admin',null);
        return vae_assign(1,'启用成功');
    }
}
