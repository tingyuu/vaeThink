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
use think\Session;
use think\Hook;

class AdminCheckLogin extends ControllerBase
{
    protected function _initialize()
    {
        parent::_initialize();
        //验证登录
        $this->checkLogin();
    }

    //验证后台模块登录
    private function checkLogin()
    {
        if(!vae_get_login_admin()) {
            $this->redirect('admin/publicer/login');
            die;
        }
    }
}