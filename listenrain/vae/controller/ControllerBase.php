<?php
namespace vae\controller;
use think\Controller;
use think\Request;

class ControllerBase extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();

        if (!vae_is_installed() && $this->request->module() != 'install') {
            header('Location: ' . '/index.php?s=install');
            die;
        }
    }
}