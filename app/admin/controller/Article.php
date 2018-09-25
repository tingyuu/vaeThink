<?php
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;
use think\Db;
use app\common\model\Article as ArticleModel;

class Article extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getContentList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['a.id|a.title|a.keywords|a.desc|a.content|w.title'] = ['like', '%' . $param['keywords'] . '%'];
        }
        if(!empty($param['article_cate_id'])) {
            $where['a.article_cate_id'] = $param['article_cate_id'];
        }
        $rows = empty($param['rows']) ? \think\Config::get('paginate.list_rows') : $param['rows'];
        $content = \think\loader::model('Article')
                ->field('*,w.id as cate_id,a.id as id,w.title as cate_title,a.title as title')
                ->alias('a')
                ->join('article_cate w','a.article_cate_id = w.id')
    			->order('a.create_time desc')
                ->where($where)
    			->paginate($rows,false,['query'=>$param]);

    	return vae_assign_table(0,'',$content);
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
    		$result = $this->validate($param, 'app\admin\validate\Article.add');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Article')->strict(false)->field(true)->insert($param);
                return vae_assign();
            }
    	}
    }

    //修改
    public function edit()
    {
        return view('',['article'=>vae_get_article_info(vae_get_param('id'))]);
    }

    //提交修改
    public function editSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Article.edit');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                \think\loader::model('Article')->where(['id'=>$param['id']])->strict(false)->field(true)->update($param);
                return vae_assign();
            }
        }
    }

    //软删除
    public function delete()
    {
        $id    = vae_get_param("id");
        if (ArticleModel::destroy($id) !== false) {
            return vae_assign(1,"成功放入回收站！");
        } else {
            return vae_assign(0,"删除失败！");
        }
    }
}
