<?php
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;

class Plugin extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getPluginList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|name|desc'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $lugin = \think\Db::name('Plugin')->where($where)->order('id asc')->paginate($rows,false,['query'=>$param]);
    	return vae_assign_table(0,'',$plugin);
    }
}
