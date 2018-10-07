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
use vae\controller\AdminCheckLogin;

class ApiController extends AdminCheckLogin
{
    //上传文件
    public function upload()
    {
        $param = vae_get_param();
        $module = isset($param['module']) ? $param['module'] : 'admin';
        $use = isset($param['use']) ? $param['use'] : 'thumb';
        $res = vae_upload($module,$use);
        if($res['code'] == 1){
            return vae_assign(1,'',$res['data']);
        }
        return vae_assign(0,$res['msg']);
    }

    //获取权限树所需的节点列表
    public function getRuleTree()
    {
        $rule = vae_get_admin_rule();
        if(!empty(vae_get_param('id'))) {
            $group = vae_get_admin_group_info(vae_get_param('id'));
        }
        $list = array();

        //先找出顶级菜单
        foreach ($rule as $k => $v) {
            if($v['pid'] == 0) {
                $list[$k] = $v;
                $list[$k]['name'] = $v['title'];
                $list[$k]['value'] = $v['id'];
                if(isset($group) and in_array($v['id'], $group['rules'])) {
                    $list[$k]['checked'] = true;
                }
                //unset($rule[$k]);
            }
        }
        //通过顶级菜单找到下属的子菜单
        foreach ($list as $k => $val) {
            foreach ($rule as $key => $v) {
                if($v['pid'] == $val['id']) {
                    $list[$k]['list'][$key] = $v;
                    $list[$k]['list'][$key]['name'] = $v['title'];
                    $list[$k]['list'][$key]['value'] = $v['id'];
                    if(isset($group) and in_array($v['id'], $group['rules'])) {
                        $list[$k]['list'][$key]['checked'] = true;
                    }
                }
                //unset($rule[$key]);
            }
        }
        //三级菜单
        foreach ($list as $k => $val) {
            if(isset($val['list'])) {
                foreach ($val['list'] as $ks => $vals) {
                    foreach ($rule as $key => $v) {
                        if($v['pid'] == $vals['id']) {
                            $list[$k]['list'][$ks]['list'][$key] = $v;
                            $list[$k]['list'][$ks]['list'][$key]['name'] = $v['title'];
                            $list[$k]['list'][$ks]['list'][$key]['value'] = $v['id'];
                            if(isset($group) and in_array($v['id'], $group['rules'])) {
                                $list[$k]['list'][$ks]['list'][$key]['checked'] = true;
                            }
                        }
                        //unset($rule[$key]);
                    }
                }
            }
        }
        $data['trees'] = $list;
        return vae_assign(0,'',$data);
    }

    //获取菜单树列表
    public function getMenuTree()
    {
        $rule = vae_get_admin_menu();
        if(!empty(vae_get_param('id'))) {
            $group = vae_get_admin_group_info(vae_get_param('id'));
        }
        $list = array();

        //先找出顶级菜单
        foreach ($rule as $k => $v) {
            if($v['pid'] == 0) {
                $list[$k] = $v;
                $list[$k]['name'] = $v['title'];
                $list[$k]['value'] = $v['id'];
                if(isset($group) and in_array($v['id'], $group['menus'])) {
                    $list[$k]['checked'] = true;
                }
                unset($rule[$k]);
            }
        }
        //通过顶级菜单找到下属的子菜单
        foreach ($list as $k => $val) {
            foreach ($rule as $key => $v) {
                if($v['pid'] == $val['id']) {
                    $list[$k]['list'][$key] = $v;
                    $list[$k]['list'][$key]['name'] = $v['title'];
                    $list[$k]['list'][$key]['value'] = $v['id'];
                    if(isset($group) and in_array($v['id'], $group['menus'])) {
                        $list[$k]['list'][$key]['checked'] = true;
                    }
                    unset($rule[$key]);
                }
            }
        }
        //三级菜单
        foreach ($list as $k => $val) {
            if(isset($val['list'])) {
                foreach ($val['list'] as $ks => $vals) {
                    foreach ($rule as $key => $v) {
                        if($v['pid'] == $vals['id']) {
                            $list[$k]['list'][$ks]['list'][$key] = $v;
                            $list[$k]['list'][$ks]['list'][$key]['name'] = $v['title'];
                            $list[$k]['list'][$ks]['list'][$key]['value'] = $v['id'];
                            if(isset($group) and in_array($v['id'], $group['menus'])) {
                                $list[$k]['list'][$ks]['list'][$key]['checked'] = true;
                            }
                            unset($rule[$key]);
                        }
                    }
                }
            }
        }
        $data['trees'] = $list;
        return vae_assign(0,'',$data);
    }

    //清空缓存
    public function cacheClear()
    {
        \think\Cache::clear();
        return vae_assign(1,'系统缓存已清空');
    }

    //发送测试邮件
    public function emailto($email)
    {
        $name = empty(vae_get_config('webconfig.admin_title'))?'vaeThink':vae_get_config('webconfig.admin_title');
        if(vae_send_email($email,"一封来自{$name}的测试邮件。")){
            return vae_assign(1,'发送成功，请注意查收');
        }
        return vae_assign(0,'发送失败');
    }

    //修改个人信息
    public function editPersonal()
    {
        return view('admin/edit_personal',[
            'admin'=>vae_get_login_admin()
        ]);
    }

    //保存个人信息修改
    public function editPersonalSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Admin.editPersonal');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                unset($param['username']);
                $aid = vae_get_login_admin('id');
                \think\loader::model('Admin')->where([
                    'id'=>$aid
                ])->strict(false)->field(true)->update($param);
                \think\Session::set('vae_admin',\think\Db::name('admin')->find($aid));
                return vae_assign();
            }
        }
    }

    //修改密码
    public function editPassword()
    {
        return view('admin/edit_password',[
            'admin'=>vae_get_login_admin()
        ]);
    }

    //保存密码修改
    public function editPasswordSubmit()
    {
        if($this->request->isPost()){
            $param = vae_get_param();
            $result = $this->validate($param, 'app\admin\validate\Admin.editPassword');
            if ($result !== true) {
                return vae_assign(0,$result);
            } else {
                $admin = vae_get_login_admin();
                if(vae_set_password($param['old_password'],$admin['salt']) !== $admin['password']) {
                    return vae_assign(0,'旧密码不正确!');
                }
                unset($param['username']);
                $param['salt']     = vae_set_salt(20);
                $param['password'] = vae_set_password($param['password'],$param['salt']);
                \think\loader::model('Admin')->where([
                    'id'=>$admin['id']
                ])->strict(false)->field(true)->update($param);
                \think\Session::set('vae_admin',\think\Db::name('admin')->find($admin['id']));
                return vae_assign();
            }
        }
    }
}
