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
        Db::name('HookPlugin')->where([
            'plugin' => $name
        ])->update([
            'status' => 0
        ]);
        cache('module_init_hook_plugin_admin',null);
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
        cache('module_init_hook_plugin_admin',null);
        return vae_assign(1,'启用成功');
    }

    //卸载
    public function uninstall()
    {
        $name =  vae_get_param('name');
        Db::startTrans();
        try{
            Db::name('plugin')->where([
                'name' => $name
            ])->delete();
            Db::name('HookPlugin')->where([
                'plugin' => $name
            ])->delete();
            cache('module_init_hook_plugin_admin',null);
            Db::commit();    
        } catch (\Exception $e) {
            Db::rollback();
            return vae_assign(0,'卸载失败:'.$e->getMessage());
        }
        return vae_assign(1,'卸载成功');
    }

    //安装
    public function install()
    {
        $param =  vae_get_param();
        $pluginModel = new PluginModel;
        $plugins = $pluginModel->install($param);
        return $plugins;
    }
}
