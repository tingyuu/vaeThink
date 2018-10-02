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

class SlideController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //管理员列表
    public function getSlideList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|name|title|desc'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $slide = \think\loader::model('Slide')
    			->order('create_time asc')
                ->where($where)
    			->paginate($rows,false,['query'=>$param]);
    	return vae_assign_table(0,'',$slide);
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
    		$result = $this->validate($param, 'app\admin\validate\Slide.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
				\think\loader::model('Slide')->strict(false)->field(true)->insert($param);
                return vae_assign();
            }
    	}
    }

    //修改
    public function edit()
    {
        $id    = vae_get_param('id');
        $slide = Db::name('slide')->find($id);
        return view('',[
            'slide'=>$slide
        ]);
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Slide.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Slide')->where([
                    'id'=>$param['id']
                ])->strict(false)->field(true)->update($param);
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        $count = Db::name('SlideInfo')->where([
            'slide_id' => $id
        ])->count();
        if($count > 0) {
            return vae_assign(0,'该组下还有幻灯片，无法删除');
        }
        if (Db::name('Slide')->delete($id) !== false) {
            return vae_assign(1,"删除成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
