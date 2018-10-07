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

class RuleController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //节点列表
    public function getRuleList()
    {
    	$menu = \think\Db::name('admin_rule')->order('create_time asc')->select();
    	return vae_assign(0,'',$menu);
    }

    //添加
    public function add()
    {
    	return view('',['pid'=>vae_get_param('pid')]);
    }

    //提交添加
    public function addSubmit()
    {
    	if($this->request->isPost()){
            $param = vae_get_param();
    		$result = $this->validate($param, 'app\admin\validate\AdminRule.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $rid = \think\loader::model('AdminRule')->strict(false)->field(true)->insertGetId($param);
                //自动为系统所有者管理组分配新增的节点
                $group = \think\loader::model('AdminGroup')->find(1);
                if(!empty($group)) {
                    $group->rules = $group->rules.','.$rid;
                    $group->save();
                }
                return vae_assign();
            }
    	}
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()) {
        	$param = vae_get_param();
        	$result = $this->validate($param, 'app\admin\validate\AdminRule.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
            	$data[$param['field']] = $param['value'];
            	$data['id'] = $param['id'];
                \think\loader::model('AdminRule')->strict(false)->field(true)->update($data);
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        $count = \think\Db::name('AdminRule')->where(["pid" => $id])->count();
        if ($count > 0) {
            return vae_assign(0,"该节点下还有子节点，无法删除！");
        }
        if (\think\Db::name('AdminRule')->delete($id) !== false) {
            return vae_assign(1,"删除节点成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
