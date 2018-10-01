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

class RouteController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getRouteList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|full_url|url'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $route = \think\Db::name('route')->order('create_time asc')->paginate($rows,false,['query'=>$param]);
    	return vae_assign_table(0,'',$route);
    }

    //添加
    public function add()
    {
    	return view();
    }

    //提交添加
    public function addSubmit()
    {
    	if($this->request->isPost()){
            $param = vae_get_param();
    		$result = $this->validate($param, 'app\admin\validate\Route.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Route')->strict(false)->field(true)->insert($param);
                \think\Cache::rm('vae_route');// 删除路由缓存
                return vae_assign();
            }
    	}
    }

    //修改
    public function edit()
    {
        $id   = vae_get_param('id');
        return view('',['route'=>\think\Db::name('route')->find($id)]);
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()) {
        	$param = vae_get_param();
        	$result = $this->validate($param, 'app\admin\validate\Route.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Route')->where(['id'=>$param['id']])->strict(false)->field(true)->update($param);
                \think\Cache::rm('vae_route');// 删除路由缓存
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        if (\think\Db::name('Route')->delete($id) !== false) {
            \think\Cache::rm('vae_route');// 删除路由缓存
            return vae_assign(1,"删除路由成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
