<?php
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