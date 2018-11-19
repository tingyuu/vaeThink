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
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;
use app\admin\model\Plugin as PluginModel;
use think\Db;

class PluginController extends AdminCheckAuth
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
        Db::name('HookPlugin')->where([
            'plugin' => $name
        ])->update([
            'status' => 0
        ]);
        $plugin = Db::name('plugin')->where('name',$name)->find();
        $hook = Db::name('hook')->where('hook',$plugin['hook'])->find();
        if($hook['type'] == 1){
            $cache_name = 'app_init_hook_plugin';
        }else{
            $module = $hook['module'];
            $cache_name = "module_init_hook_plugin_{$module}";
        }
        cache($cache_name,null);
        return vae_assign(1,'禁用成功');
    }

    //启用
    public function start()
    {
        $name =  vae_get_param('name');
        Db::name('HookPlugin')->where([
            'plugin' => $name
        ])->update([
            'status' => 1
        ]);
        $plugin = Db::name('plugin')->where('name',$name)->find();
        $hook = Db::name('hook')->where('hook',$plugin['hook'])->find();
        if($hook['type'] == 1){
            $cache_name = 'app_init_hook_plugin';
        }else{
            $module = $hook['module'];
            $cache_name = "module_init_hook_plugin_{$module}";
        }
        cache($cache_name,null);
        return vae_assign(1,'启用成功');
    }

    //卸载
    public function uninstall()
    {
        $name =  vae_get_param('name');
        $pluginModel = new PluginModel;
        $plugins = $pluginModel->uninstall($name);
        return $plugins;
    }

    //安装
    public function install()
    {
        $param =  vae_get_param();
        $pluginModel = new PluginModel;
        $plugins = $pluginModel->install($param);
        return $plugins;
    }

    //配置
    public function setConfig()
    {
        $name =  vae_get_param('name');
        $pluginModel = new PluginModel;
        $plugins = $pluginModel->setConfig($name);
        return $plugins;
    }
}
