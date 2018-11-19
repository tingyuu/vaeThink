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

class CateController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getCateList()
    {
    	$cate = \think\Db::name('ArticleCate')->order('create_time asc')->select();
    	return vae_assign(0,'',$cate);
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
    		$result = $this->validate(vae_get_param(), 'app\admin\validate\ArticleCate.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('ArticleCate')->cache('VAE_ARTICLE_CATE')->strict(false)->field(true)->insert(vae_get_param());
                return vae_assign();
            }
    	}
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()) {
        	$param = vae_get_param();
        	$result = $this->validate($param, 'app\admin\validate\ArticleCate.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
            	$data[$param['field']] = $param['value'];
            	$data['id'] = $param['id'];
                \think\loader::model('ArticleCate')->cache('VAE_ARTICLE_CATE')->strict(false)->field(true)->update($data);
                return vae_assign();
            }
        }
    }

    //删除
    public function delete()
    {
        $id    = vae_get_param("id");
        $cate_count = \think\Db::name('ArticleCate')->where(["pid" => $id])->count();
        if ($cate_count > 0) {
            return vae_assign(0,"该分类下还有子分类，无法删除！");
        }
        $content_count = \think\Db::name('Article')->where(["article_cate_id" => $id])->count();
        if ($content_count > 0) {
            return vae_assign(0,"该分类下还有文章，无法删除！");
        }
        if (\think\Db::name('ArticleCate')->cache('VAE_ARTICLE_CATE')->delete($id) !== false) {
            return vae_assign(1,"删除分类成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
