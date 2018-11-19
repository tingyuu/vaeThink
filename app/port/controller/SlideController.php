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

class SlideController extends PortControllerBase
{
   // 轮播图
   public function getSlideList()
   {
       $name = $this->param('name')?$this->param('name'):"VAE_INDEX_SLIDE";
       $slide = Db::name('slide')->field($this->field)->where([
       	'name'  =>$name,
       	'status'=>1
       ])->cache($name,config('webconfig.port_cache_time'),'VAE_SALIDE')->find();
       if(empty($slide)) {
           return $this->port(0,'无此分组或已禁用');
       } else {
       		$slide_info = Db::name('slide_info')->where([
       			'slide_id'=>$slide['id'],
       			'status'  =>1
       		])->cache('SALIDE_INFO_'.$name,config('webconfig.port_cache_time'),'VAE_SALIDE_INFO')->select();
       		//处理图片路径
       		foreach ($slide_info as $k => $v) {
       			$slide_info[$k]['img'] = config('webconfig.domain').$v['img'];
       		}
       		return $this->port(1,'ok',$slide_info);
       }
   }
}
