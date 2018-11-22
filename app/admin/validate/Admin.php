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
namespace app\admin\validate;
use think\Validate;
use think\Db;

class Admin extends Validate
{
    protected $rule = [
        'username'       => 'require|unique:admin',
        'pwd'       => 'require|confirm',
        'phone'          => 'require',
        'nickname'       => 'require',
        'thumb'          => 'require',
        'group_id'       => 'require',
        'id'             => 'require',
        'status'         => 'require|checkStatus:-1,1',
        'old_pwd'   => 'require|different:pwd',
    ];

    protected $message = [
        'username.require'          => '用户名不能为空',
        'pwd.require'          => '密码不能为空',
        'pwd.confirm'          => '两次密码不一致',
        'username.unique'           => '同样的记录已经存在!',
        'phone.require'             => '手机不能为空',
        'nickname.require'          => '昵称不能为空',
        'thumb.require'             => '头像不能为空',
        'group_id.require'          => '至少要选择一个分组',
        'id.require'                => '缺少更新条件',
        'status.require'            => '状态为必选',
        'status.checkStatus'        => '系统所有者不能被禁用!',
        'old_pwd.require'      => '请提供旧密码',
        'old_pwd.different'    => '新密码不能和旧密码一样',
    ];

    protected $scene = [
        'add'          => ['phone', 'nickname', 'thumb', 'group_id', 'pwd', 'username', 'status'],
        'edit'         => ['phone', 'nickname', 'thumb', 'group_id', 'id', 'username.unique', 'status'],
        'editPersonal' => ['phone', 'nickname', 'thumb'],
        'editpwd' => ['old_pwd', 'pwd'],
    ];

    // 自定义验证规则
    protected function checkStatus($value,$rule,$data)
    {
        if($value == -1 and $data['id'] == 1) {
            return $rule == false;
        }
        return $rule == true;
    }
}