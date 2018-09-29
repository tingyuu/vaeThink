<?php
namespace app\admin\controller;
use vae\controller\AdminCheckLogin;

class Main extends AdminCheckLogin
{
    public function index()
    {

        vae_set_hook('admin_main');

        return $this->fetch();
    }
}
