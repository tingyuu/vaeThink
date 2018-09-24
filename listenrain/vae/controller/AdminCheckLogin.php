<?php
namespace vae\controller;
use vae\controller\ControllerBase;
use think\Session;

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
        if(!Session::has('vae_admin')) {
            $this->redirect('admin/publicer/login');
            die;
        }
    }
}