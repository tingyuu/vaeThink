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

    //列表
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
                \think\Cache::clear('VAE_SALIDE');
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
            \think\Cache::clear('VAE_SALIDE');
        } else {
            return vae_assign(0,"删除失败！");
        }
    }

    //管理幻灯片
    public function slideInfo()
    {
        return view('',[
            'slide_id' => vae_get_param('id')
        ]);
    }

    //幻灯片列表
    public function getSlideInfoList()
    {
        $id            = vae_get_param('id');
        $slideInfoList = Db::name('SlideInfo')->where([
            'slide_id' => $id
        ])->select();
        return vae_assign(0,'',$slideInfoList);
    }

    //添加幻灯片
    public function addSlideInfo()
    {
        return view('',[
            'slide_id' => vae_get_param('id')
        ]);
    }

    //保存幻灯片添加
    public function addSlideInfoSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Slide.addInfo');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('SlideInfo')->strict(false)->field(true)->insert($param);
                \think\Cache::clear('VAE_SALIDE_INFO');
                return vae_assign();
            }
        }
    }

    //修改幻灯片
    public function editSlideInfo()
    {
        $id = vae_get_param('id');
        $slideInfo = Db::name('SlideInfo')->find($id);
        return view('',[
            'slideInfo' => $slideInfo
        ]);
    }

    //保存幻灯片修改
    public function editSlideInfoSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Slide.editInfo');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('SlideInfo')->where([
                    'id' => $param['id']
                ])->strict(false)->field(true)->update($param);
                \think\Cache::clear('VAE_SALIDE_INFO');
                return vae_assign();
            }
        }
    }

    //删除幻灯片
    public function deleteSlideInfo()
    {
        $id    = vae_get_param("id");
        if (Db::name('SlideInfo')->delete($id) !== false) {
            return vae_assign(1,"删除成功！");
            \think\Cache::clear('VAE_SALIDE_INFO');
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
