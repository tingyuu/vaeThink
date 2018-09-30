<?php

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
}