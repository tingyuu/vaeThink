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

class Plugin extends Model
{
	public function getPlugin()
	{
		$dirArray[]=NULL;
        if (false != ($handle = opendir ( './plugin/' ))) {
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
            cache('module_init_hook_plugin_admin',null);
            Db::commit();    
        } catch (\Exception $e) {
            Db::rollback();
            return vae_assign(0,'安装失败:'.$e->getMessage());
        }
        return vae_assign(1,'安装成功');
    }
}