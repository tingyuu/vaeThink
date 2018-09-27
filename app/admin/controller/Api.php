<?php
namespace app\admin\controller;
use vae\controller\AdminCheckLogin;

class Api extends AdminCheckLogin
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
        if(vae_send_email($email,'一封来自vaeThink的测试邮件。')){
            return vae_assign(1,'发送成功，请注意查收');
        }
        return vae_assign(0,'发送失败');
    }
}
