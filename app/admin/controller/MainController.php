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
use vae\controller\AdminCheckLogin;

class MainController extends AdminCheckLogin
{
    public function index()
    {
        $adminMainHook = vae_set_hook_one('admin_main');
        if(!empty($adminMainHook)) {
        	return $adminMainHook;
        }
        return $this->fetch();
    }
}
