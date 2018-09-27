<?php
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;
use think\Db;

class Group extends AdminCheckAuth
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
            if($this->request->isPost()){
                $param = vae_get_param();
                $result = $this->validate($param, 'app\admin\validate\AdminGroup.edit');
                if ($result !== true) {
                    return vae_assign(0,$result);
                } else {
                    if(!empty($param['rules'])) {
                        $param['rules'] = implode(',',$param['rules']);
                    }
                    \think\loader::model('AdminGroup')->where(['id'=>$param['id']])->strict(false)->field(true)->update($param);
                    return vae_assign();
                }
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
