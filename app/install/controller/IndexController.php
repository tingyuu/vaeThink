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
namespace app\install\controller;
use vae\controller\ControllerBase;
use mysqli;

class IndexController extends ControllerBase
{
    public function _initialize()
    {
        parent::_initialize();
        
        // 检测是否安装过
        if (vae_is_installed()) {
            return $this->error('你已经安装过该系统!');
        }
    }

    public function index()
    {
        return $this->fetch('step1');
    }

    public function step2()
    {
        if (class_exists('pdo')) {
            $data['pdo'] = 1;
        } else {
            $data['pdo'] = 0;
        }

        if (extension_loaded('pdo_mysql')) {
            $data['pdo_mysql'] = 1;
        } else {
            $data['pdo_mysql'] = 0;
        }

        if (extension_loaded('curl')) {
            $data['curl'] = 1;
        } else {
            $data['curl'] = 0;
        }

        if (ini_get('file_uploads')) {
            $data['upload_size'] = ini_get('upload_max_filesize');
        } else {
            $data['upload_size'] = 0;
        }

        if (function_exists('session_start')) {
            $data['session'] = 1;
        } else {
            $data['session'] = 0;
        }

        return $this->fetch('',['data'=>$data]);
    }
    
    
    public function step3()
    {
        return $this->fetch();
    }

    public function createData()
    {
        if($this->request->isPost()){
            $data = vae_get_param();
            $result = $this->validate($data, 'app\install\validate\Index');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                // 连接数据库
                $link=@new mysqli("{$data['DB_HOST']}:{$data['DB_PORT']}",$data['DB_USER'],$data['DB_PWD']);
                // 获取错误信息
                $error=$link->connect_error;
                if (!is_null($error)) {
                    // 转义防止和alert中的引号冲突
                    $error=addslashes($error);
                    return vae_assign(0,'数据库链接失败:'.$error);die;
                }
                // 设置字符集
                $link->query("SET NAMES 'utf8'");
                if($link->server_info < 5.0){
                    return vae_assign(0,'请将您的mysql升级到5.0以上');die;
                }
                // 创建数据库并选中
                if(!$link->select_db($data['DB_NAME'])){
                    $create_sql='CREATE DATABASE IF NOT EXISTS '.$data['DB_NAME'].' DEFAULT CHARACTER SET utf8;';
                    if(!$link->query($create_sql)){
                        return vae_assign(0,'数据库链接失败');die;
                    }
                    $link->select_db($data['DB_NAME']);
                }
                // 导入sql数据并创建表
                $vaethink_sql=file_get_contents(APP_PATH . 'install/data/vaethink.sql');
                $sql_array=preg_split("/;[\r\n]+/", str_replace('vae_',$data['DB_PREFIX'],$vaethink_sql));
                foreach ($sql_array as $k => $v) {
                    if (!empty($v)) {
                        $link->query($v);
                    }
                }
                $link->close();
                $db_str="
<?php

return [

    // 数据库类型
    'type'               =>  'mysql',
    // 服务器地址
    'hostname'           =>  '{$data['DB_HOST']}',
    // 数据库名
    'database'           =>  '{$data['DB_NAME']}', 
    // 用户名
    'username'           =>  '{$data['DB_USER']}',
    // 密码
    'password'           =>  '{$data['DB_PWD']}',
    // 端口
    'hostport'           =>  '{$data['DB_PORT']}',
    // 数据库表前缀
    'prefix'             =>  '{$data['DB_PREFIX']}',  
];";

                
                // 创建数据库配置文件
                if(false == file_put_contents(VAE_ROOT . "data/conf/database.php",$db_str)) {
                    return vae_assign(0,'创建数据库配置文件失败，请检查目录权限');
                }
                if(false == file_put_contents(VAE_ROOT . "data/install.lock",'vaeThink安装鉴定文件，勿删！！！！！此次安装时间：'.date('Y-m-d H:i:s',time()))) {
                    return vae_assign(0,'创建安装鉴定文件失败，请检查目录权限');
                }
                
                sleep(2);
                //创建管理员信息
                $param = array();
                $param['username']    = vae_get_param('username');
                $param['password']    = vae_get_param('password');
                $param['nickname']    = 'Admin';
                $param['thumb']       = '/themes/admin_themes/lib/vaeyo/img/thumb.png';
                $param['desc']        = '系统所有者。';
                $param['salt']        = vae_set_salt(20);
                $param['password']    = vae_set_password($param['password'],$param['salt']);
                $param['create_time'] = time();
                $param['update_time'] = time();
                
                \think\Db::name('Admin')->strict(false)->field(true)->insert($param);
                \think\Db::name('AdminGroupAccess')->strict(false)->field(true)->insert([
                    'uid'         => 1,
                    'group_id'    => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ]);
                
                return vae_assign();
            }
        }
    }   
}

