<?php
namespace vae\controller;
use vae\controller\AdminCheckLogin;

class AdminCheckAuth extends AdminCheckLogin
{
    protected function _initialize()
    {
        parent::_initialize();
        
        $this->checkAuth();
    }

    private function checkAuth()
    {
        $controller = strtolower($this->request->controller());
        $action = strtolower($this->request->action());

        $auth = new \vae\lib\Auth();
        if(false == $auth->check($controller.'/'.$action,vae_get_login_admin('id'))){
            return vae_assign(0,'您没有权限,请联系系统所有者');
        }
    }
}