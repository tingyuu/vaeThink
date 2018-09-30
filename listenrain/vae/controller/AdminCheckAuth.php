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
use vae\controller\AdminCheckLogin;
use think\Hook;

class AdminCheckAuth extends AdminCheckLogin
{
    protected function _initialize()
    {
        parent::_initialize();

        $params = [
            'controller' => strtolower($this->request->controller()),
            'action'  => strtolower($this->request->action()),
            'admin_id' => vae_get_login_admin('id')
        ];
        
        Hook::listen('admin_init',$params);
    }
}