<?php
namespace app\admin\controller;
use vae\controller\ControllerBase;
use think\Db;

class Publicer extends ControllerBase
{
    public function login()
    {
        return $this->fetch();
    }

    public function loginSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Publicer');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $admin = Db::name('admin')->where(['username'=>$param['username']])->find();
                if(empty($admin)) {
                    return vae_assign(0,'用户名或密码错误');
                }
                $param['password'] = vae_set_password($param['password'],$admin['salt']);
                if($admin['password'] !== $param['password']) {
                    return vae_assign(0,'用户名或密码错误');
                }
                if($admin['status'] == -1){
                    return vae_assign(0,'该用户禁止登陆,请于系统所有者联系');
                }
                $data = [
                    'last_login_time' => time(),
                    'last_login_ip' => $this->request->ip(),
                    'login_num' => $admin['login_num'] + 1
                ];
                Db::name('admin')->where(['id'=>$admin['id']])->update($data);
                \think\Session::set('vae_admin',$admin);
                return vae_assign(1,'登入成功');
            }
        }
    }

    public function logout()
    {
        \think\Session::delete('vae_admin');
        return vae_assign(1,"退出成功");
    }
}
