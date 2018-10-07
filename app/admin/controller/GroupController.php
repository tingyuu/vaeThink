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
use think\Db;

class GroupController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //管理员列表
    public function getGroupList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|title|desc'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $group = \think\loader::model('AdminGroup')
    			->order('create_time asc')
                ->where($where)
    			->paginate($rows,false,['query'=>$param]);

    	return vae_assign_table(0,'',$group);
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
    		$result = $this->validate($param, 'app\admin\validate\AdminGroup.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
            	if(!empty($param['rules'])) {
                    $param['rules'] = implode(',',$param['rules']);
                }
                if(!empty($param['menus'])) {
                    $param['menus'] = implode(',',$param['menus']);
                }
			    \think\loader::model('AdminGroup')->strict(false)->field(true)->insert($param);
                return vae_assign();
            }
    	}
    }

    //修改
    public function edit()
    {
        $id = vae_get_param('id');
        return view('',['id'=>$id,'group'=>vae_get_admin_group_info($id)]);
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\AdminGroup.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                //为了系统安全id为1的系统所有者管理组不允许修改
                if($param['id'] == 1) {
                    return vae_assign(0,'为了系统安全,该管理组不允许修改');
                }
                if(!empty($param['rules'])) {
                $param['rules'] = implode(',',$param['rules']);
                }
                if(!empty($param['menus'])) {
                    $param['menus'] = implode(',',$param['menus']);
                }
                \think\loader::model('AdminGroup')->where(['id'=>$param['id']])->strict(false)->field(true)->update($param);
                //清除菜单缓存
                \think\Cache::clear('VAE_ADMIN_MENU');
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        if ($id == 1) {
            return vae_assign(0,"该组是系统所有者，无法删除！");
        }
        if (Db::name('AdminGroup')->delete($id) !== false) {
            return vae_assign(1,"删除管理组成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
