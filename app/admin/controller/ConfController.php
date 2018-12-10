<?php
// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +---------------------------------------------------------------------
namespace app\admin\controller;
use vae\controller\AdminCheckAuth;
use think\Config;

class ConfController extends AdminCheckAuth
{
    //网站信息
    public function webConf()
    {
        $conf = Config::get('webconfig');
        $webConf = [
            'title'        => empty($conf['title']) ? '' : $conf['title'],
            'keywords'     => empty($conf['keywords']) ? '' : $conf['keywords'],
            'desc'         => empty($conf['desc']) ? '' : $conf['desc'],
            'logo'         => empty($conf['logo']) ? '' : $conf['logo'],
            'admin_title'  => empty($conf['admin_title']) ? '' : $conf['admin_title'],
            'icp'          => empty($conf['icp']) ? '' : $conf['icp'],
            'code'         => empty($conf['code']) ? '' : $conf['code'],
            'domain'       => empty($conf['domain']) ? '' : $conf['domain'],
            'port_cache_time' => empty($conf['port_cache_time']) ? '' : $conf['port_cache_time'],
        ];
        return view('',['webConf'=>$webConf]);
    }

    //提交网站信息
    public function webConfSubmit()
    {
    	if($this->request->isPost()){
            $param = vae_get_param();
    		$result = $this->validate($param, 'app\admin\validate\Conf.webConf');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $conf = "<?php return ['admin_title'=>'{$param["admin_title"]}','title'=>'{$param["title"]}','keywords'=>'{$param["keywords"]}','logo'=>'{$param["logo"]}','desc'=>'{$param["desc"]}','icp'=>'{$param["icp"]}','code'=>'{$param["code"]}','domain'=>'{$param["domain"]}','port_cache_time'=>'{$param["port_cache_time"]}'];";
                file_put_contents(VAE_ROOT . "data/conf/extra/webconfig.php",$conf);
                return vae_assign();
            }
    	}
    }

    //邮箱配置
    public function emailConf()
    {
        $conf = Config::get('emailconfig');
        $emailConf = [
            'smtp'     => empty($conf['smtp']) ? '' : $conf['smtp'],
            'username' => empty($conf['username']) ? '' : $conf['username'],
            'password' => empty($conf['password']) ? '' : $conf['password'],
            'port'     => empty($conf['port']) ? '' : $conf['port'],
            'email'    => empty($conf['email']) ? '' : $conf['email'],
            'from'     => empty($conf['from']) ? '' : $conf['from'],
            'template' => empty($conf['template']) ? '' : $conf['template'],
        ];
        return view('',['emailConf'=>$emailConf]);
    }

    //提交邮箱配置
    public function emailConfSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Conf.emailConf');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $conf = "<?php return ['smtp'=>'{$param["smtp"]}','username'=>'{$param["username"]}','password'=>'{$param["password"]}','port'=>'{$param["port"]}','email'=>'{$param["email"]}','from'=>'{$param["from"]}','template'=>'{$param["template"]}'];";
                file_put_contents(VAE_ROOT . "data/conf/extra/emailconfig.php",$conf);
                return vae_assign();
            }
        }
    }

    //大鱼短信配置
    public function dayuConf()
    {
        $conf = Config::get('dayuconfig');
        $dayuConf = [
            'appkey'     => empty($conf['appkey']) ? '' : $conf['appkey'],
            'secretkey' => empty($conf['secretkey']) ? '' : $conf['secretkey'],
            'FreeSignName' => empty($conf['FreeSignName']) ? '' : $conf['FreeSignName']
        ];
        return view('',['dayuConf'=>$dayuConf]);
    }

    //提交大鱼短信配置
    public function dayuConfSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Conf.dayuConf');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $conf = "<?php return ['appkey'=>'{$param["appkey"]}','secretkey'=>'{$param["secretkey"]}','FreeSignName'=>'{$param["FreeSignName"]}'];";
                file_put_contents(VAE_ROOT . "data/conf/extra/dayuconfig.php",$conf);
                return vae_assign();
            }
        }
    }
}
