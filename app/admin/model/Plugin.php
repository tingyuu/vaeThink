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
namespace app\admin\model;
use think\Db;
use think\Model;
use think\Exception;

class Plugin extends Model
{
	public function getPlugin()
	{
		$dirArray[]=NULL;
        if (false != ($handle = opendir ( PLUGIN_PATH ))) {
            $i=0;
            while ( false !== ($file = readdir ( $handle )) ) {
                //去掉"“.”、“..”以及带“.xxx”后缀的文件
                if ($file != "." && $file != ".."&&!strpos($file,".")) {
                    $dirArray[$i]=\think\Loader::parseName($file, 1);
                    $i++;
                }
            }
            //关闭句柄
            closedir ( $handle );
        }
        
        $plugin = array();
        foreach ($dirArray as $k => $v) {
        	$class = vae_get_plugin_class($v);
        	if (class_exists($class)) {
        		$pluginIndex = new $class;
            	$plugin[$k] = $pluginIndex->explain;
            	$plugin[$k]['status'] = empty($this->where(['name'=>$v])->find()) ? 0 : 1;
            	$plugin[$k]['start'] = empty(Db::name('HookPlugin')->where(['plugin'=>$v])->value('status')) ? 0 : 1;
            }
        }
        return $plugin;
	}

    public function install($param)
    {
        try{
            
            $this->strict(false)->field(true)->insert($param);
            Db::name('HookPlugin')->insert([
                'hook'    => $param['hook'],
                'plugin'  => $param['name'],
            ]);



            $plugin = Db::name('plugin')->where('name',$param['name'])->find();
            $hook = Db::name('hook')->where('hook',$plugin['hook'])->find();
            if($hook['type'] == 1){
                $cache_name = 'app_init_hook_plugin';
            }else{
                $module = $hook['module'];
                $cache_name = "module_init_hook_plugin_{$module}";
            }
            cache($cache_name,null);

            $class = vae_get_plugin_class($param['name']);
            if (!class_exists($class)) {
                throw new Exception("当前插件类库不存在，请检查命名空间是否符合规范", 1);
            }
            $pluginIndex = new $class;
            $pluginIndex->install();

            Db::commit();    
        } catch (\Exception $e) {
            Db::rollback();
            return vae_assign(0,'安装失败:'.$e->getMessage());
        }
        return vae_assign(1,'安装成功');
    }

    public function uninstall($name)
    {
        Db::startTrans();
        try{

            $plugin = Db::name('plugin')->where('name',$name)->find();
            
            Db::name('plugin')->where([
                'name' => $name
            ])->delete();
            Db::name('HookPlugin')->where([
                'plugin' => $name
            ])->delete();

            $hook = Db::name('hook')->where('hook',$plugin['hook'])->find();
            if($hook['type'] == 1){
                $cache_name = 'app_init_hook_plugin';
            }else{
                $module = $hook['module'];
                $cache_name = "module_init_hook_plugin_{$module}";
            }
            cache($cache_name,null);

            $class = vae_get_plugin_class($name);
            if (!class_exists($class)) {
                throw new Exception("当前插件类库不存在，请检查命名空间是否符合规范", 1);
            }
            $pluginIndex = new $class;
            $pluginIndex->uninstall();

            Db::commit();    
        } catch (\Exception $e) {
            Db::rollback();
            return vae_assign(0,'卸载失败:'.$e->getMessage());
        }
        return vae_assign(1,'卸载成功');
    }

    public function setConfig($name)
    {
        $plugin = Db::name('plugin')->where([
            'name' => $name
        ])->find();
        if(empty($plugin)) {
            return vae_assign(0,'该插件未安装');
        }
        $class = vae_get_plugin_class($name);
        if (!class_exists($class)) {
            throw new Exception("当前插件类库不存在，请检查命名空间是否符合规范", 1);
        }
        $pluginIndex = new $class;
        return $pluginIndex->setConfig();
    }
}