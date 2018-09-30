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
namespace vae\behavior;
use think\Db;

class AdminCheckAuth {
	public function run(&$params){   
		$auth = new \vae\lib\Auth();
        if(false == $auth->check($params['controller'].'/'.$params['action'],$params['admin_id'])){
            return vae_assign(0,'您没有权限,请联系系统所有者');
        }
    }
}