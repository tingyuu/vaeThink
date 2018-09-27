<?php
namespace app\admin\controller;
use vae\controller\AdminCheckLogin;
use think\Hook;

class Main extends AdminCheckLogin
{
    public function index()
    {

        Hook::listen('admin_main');

        return $this->fetch();
    }
}
