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
use app\common\model\Article;

class RecycleController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getRecycleList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['a.id|a.title|a.keywords|a.desc|a.content|w.title'] = ['like', '%' . $param['keywords'] . '%'];
        }
        if(!empty($param['article_cate_id'])) {
            $where['a.article_cate_id'] = $param['article_cate_id'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $recycle = Article::onlyTrashed()
                ->field('*,w.id as cate_id,a.id as id,w.title as cate_title,a.title as title')
                ->alias('a')
                ->join('article_cate w','a.article_cate_id = w.id')
    			->order('a.delete_time desc')
                ->where($where)
    			->paginate($rows,false,['query'=>$param])
                ->each(function($item, $key){
                    $item->delete_time = date('Y-m-d H:i:s',$item->delete_time);
                });

    	return vae_assign_table(0,'',$recycle);
    }

    //还原
    public function reduction()
    {
        $id    = vae_get_param("id");
        $i = \think\loader::model('Article')->save(['delete_time'=>Null],['id'=>$id]);
        return vae_assign(1,'还原成功');
    }

    //彻底删除
    public function delete()
    {
        $id    = vae_get_param("id");
        if (Article::destroy($id,true) !== false) {
            return vae_assign(1,"删除成功！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
