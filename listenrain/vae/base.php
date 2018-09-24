<?php

//引入框架函数库
include VAE_LTR . 'common/function.php';
//引入框架核心文件
include VAE_LTR . 'start.php';
//自动加载类库
spl_autoload_register('\vae\start::load');
//启动框架
//\vaephp\vae::run();