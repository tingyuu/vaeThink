<?php
namespace vae\controller;
use think\Controller;
use think\Request;

class ControllerBase extends Controller
{
    public function __construct(Request $request = null)
    {
        if (!vae_is_installed() && $request->module() != 'install') {
            header('Location: ' . '/index.php?s=install');
            die;
        }

        if (is_null($request)) {
            $request = Request::instance();
        }

        $this->request = $request;
    }

    protected function _initialize()
    {
        parent::_initialize();
    }
}