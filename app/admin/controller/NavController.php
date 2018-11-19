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

class NavController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getNavList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|name|title|desc'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $nav = \think\loader::model('Nav')
    			->order('create_time asc')
                ->where($where)
    			->paginate($rows,false,['query'=>$param]);
    	return vae_assign_table(0,'',$nav);
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
    		$result = $this->validate($param, 'app\admin\validate\Nav.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
				\think\loader::model('Nav')->strict(false)->field(true)->insert($param);
                return vae_assign();
            }
    	}
    }

    //修改
    public function edit()
    {
        $id    = vae_get_param('id');
        $nav = Db::name('nav')->find($id);
        return view('',[
            'nav'=>$nav
        ]);
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Nav.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Nav')->where([
                    'id'=>$param['id']
                ])->strict(false)->field(true)->update($param);
                \think\Cache::clear('VAE_NAV');
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        $count = Db::name('NavInfo')->where([
            'nav_id' => $id
        ])->count();
        if($count > 0) {
            return vae_assign(0,'该组下还有导航，无法删除');
        }
        if (Db::name('Nav')->delete($id) !== false) {
            return vae_assign(1,"删除成功！");
            \think\Cache::clear('VAE_NAV');
        } else {
            return vae_assign(0,"删除失败！");
        }
    }

    //管理导航
    public function navInfo()
    {
        return view('',[
            'nav_id' => vae_get_param('id')
        ]);
    }

    //导航列表
    public function getNavInfoList()
    {
        $id            = vae_get_param('id');
        $navInfoList = Db::name('NavInfo')->where([
            'nav_id' => $id
        ])->order('order asc')->select();
        return vae_assign(0,'',$navInfoList);
    }

    //添加导航
    public function addNavInfo()
    {
        return view('',[
            'nav_id' => vae_get_param('id'),
            'pid' => vae_get_param('pid')
        ]);
    }

    //保存添加
    public function addNavInfoSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Nav.addInfo');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('NavInfo')->strict(false)->field(true)->insert($param);
                //清除导航缓存
                \think\Cache::clear('VAE_NAV');
                return vae_assign();
            }
        }
    }

    //保存修改
    public function editNavInfoSubmit()
    {
        if($this->request->isPost()) {
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Nav.editInfo');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $data[$param['field']] = $param['value'];
                $data['id'] = $param['id'];
                \think\loader::model('NavInfo')->strict(false)->field(true)->update($data);
                //清除导航缓存
                \think\Cache::clear('VAE_NAV');
                return vae_assign();
            }
        }
    }

    //删除
    public function deleteNavInfo()
    {
        $id    = vae_get_param("id");
        if (Db::name('NavInfo')->delete($id) !== false) {
            //清除导航缓存
            \think\Cache::clear('VAE_NAV');
            return vae_assign(1,"删除成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
