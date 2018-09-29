<?php
namespace app\admin\controller;
use vae\controller\AdminCheckLogin;

class Main extends AdminCheckLogin
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
