<?php
// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +----------------------------------------------------------------------
namespace vae\controller;
use vae\controller\ControllerBase;

class PortControllerBase extends ControllerBase
{
    protected $rows;
    protected $page;
    protected $field;

    public function _initialize()
    {
        parent::_initialize();
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $this->rows = !empty($this->param('rows')) ? $this->param('rows') : 5;
        $this->page = !empty($this->param('page')) ? $this->param('page') : 1;
        $this->field = !empty($this->param('field')) ? json_decode($this->param('field'),true) : '*';
        $param = $this->param();
        vae_set_hook('port_begin',$param);
    }

    protected static function port($code=1, $msg="OK", $data=[], $url='', $httpCode=200, $header = [], $options = []){
        $port =  vae_assign($code, $msg, $data, $url, $httpCode, $header, $options);
        vae_set_hook('port_return',$port);
        return $port;
    }

    protected static function param($key=""){
        $param = vae_get_param();
        vae_set_hook('port_param',$param);
        if(!empty($key) and isset($param[$key])){
            $param = $param[$key]; 
        } else if(!empty($key) and !isset($param[$key])){
            $param = null;
        } else {
            $param = $param;
        }
        return $param;
    }

    protected static function setThumb($thumb="",$i=false){
        if($i){
            $thumb = explode(',',$thumb);
            foreach ($thumb as $k => $v) {
                $thumb[$k] = config('webconfig.domain').$v;
            }
        } else {
            $thumb = config('webconfig.domain').$thumb;
        }
        return $thumb;
    }
}