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