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
                $sql_array=preg_split("/;[\r\n]+/", str_replace("vae_",$data['DB_PREFIX'],$vaethink_sql));
                foreach ($sql_array as $k => $v) {
                    if (!empty($v)) {
                        $link->query($v);
                    }
                }

                //插入管理员
                $username    = vae_get_param('username');
                $password    = vae_get_param('password');
                $nickname    = 'Admin';
                $thumb       = '/themes/admin_themes/lib/vaeyo/img/thumb.png';
                $salt       = vae_set_salt(20);
                $password    = vae_set_password($password,$salt);
                $create_time = time();
                $update_time = time();

                $caeate_admin_sql = "INSERT INTO ".$data['DB_PREFIX']."admin ".
                "(username,pwd, nickname,thumb,salt,create_time,update_time) "
                ."VALUES "
                ."('$username','$password','$nickname','$thumb','$salt','$create_time','$update_time')";
                if(!$link->query($caeate_admin_sql)) {
                    return vae_assign(0,'创建管理员信息失败');
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
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 自动读取主库数据
    'read_master'     => false,
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => true,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8', 
];";

                
                // 创建数据库配置文件
                if(false == file_put_contents(VAE_ROOT . "data/conf/database.php",$db_str)) {
                    return vae_assign(0,'创建数据库配置文件失败，请检查目录权限');
                }
                if(false == file_put_contents(VAE_ROOT . "data/install.lock",'vaeThink安装鉴定文件，勿删！！！！！此次安装时间：'.date('Y-m-d H:i:s',time()))) {
                    return vae_assign(0,'创建安装鉴定文件失败，请检查目录权限');
                }
                
                return vae_assign();
            }
        }
    }  
}

