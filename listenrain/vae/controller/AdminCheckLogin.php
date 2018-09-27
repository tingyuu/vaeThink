<?php
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