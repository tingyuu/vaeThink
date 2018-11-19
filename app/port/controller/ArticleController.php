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
namespace app\port\controller;
use vae\controller\PortControllerBase;
use \think\Db;

class ArticleController extends PortControllerBase
{
    public function getArticleCate()
    {
        return $this->port(1,'ok',Db::name('article_cate')->field($this->field)->where([
        'pid'    => empty($this->param('pid'))?0:$this->param('pid')
        ])->cache('VAE_ARTICLE_CATE',config('webconfig.port_cache_time'))
        ->order('create_time desc')->select());
    }

   // 列表
   public function getArticleList()
   {
        $where = [
            'status' => 1
        ];

        $param = $this->param();

        if(isset($param['article_cate_id']) and !empty($param['article_cate_id'])){
            $where['article_cate_id'] = $param['article_cate_id'];
        }

        if(isset($param['keywords']) and !empty($param['keywords'])) {
            $where['title|keywords|desc|content'] = ['like', '%' . $param['keywords'] . '%'];
        }

        $article_list = \think\Loader::model('article')
                        ->field($this->field)
                        ->where($where)
                        ->order('create_time desc')
                        ->paginate($this->rows,false,[
                          'page' =>$this->page,
                          'query'=>$param
                        ])->each(function($item, $key){
                            if($this->field === '*' or in_array('thumb', $this->field)){
                              $item->thumb = $this->setThumb($item->thumb);
                            }
                            if($this->field === '*' or in_array('content', $this->field)){
                              $item->content = preg_replace('/src=\\"/', 'src="'.config('webconfig.domain'),$item->content);
                            }
                        });
        return $this->port(1,'ok',$article_list);
   }

   //详情
   public function getArticleInfo()
   {
        if(empty($this->param('id'))){
            return $this->port(0,'缺少查询条件');
        }
        $article_info = Db::name('article')->field($this->field)->where([
                          'status' => 1
                        ])->cache($this->param('id'),config('webconfig.port_cache_time'),'VAE_ARTICLE_INFO')->find($this->param('id'));
        if(empty($article_info)){
            return $this->port(0,'内容不存在或已下架');
        }
        Db::name('article')->where('id',$this->param('id'))->setInc('read');
        if($this->field === '*' or in_array('thumb', $this->field)){
            $article_info['thumb'] = $this->setThumb($article_info['thumb']);
        }
        if($this->field === '*' or in_array('content', $this->field)){
            $article_info['content'] = preg_replace('/src=\\"/', 'src="'.config('webconfig.domain'), $article_info['content']);
        }
        if($this->field === '*' or in_array('create_time', $this->field)){
            $article_info['create_time'] = date('Y-m-d H:i:s',$article_info['create_time']);
        }
        return $this->port(1,'ok',$article_info);
   }
}
