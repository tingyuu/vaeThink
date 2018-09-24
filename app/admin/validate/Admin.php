<?php

namespace app\admin\validate;

use think\Validate;
use think\Db;

class Admin extends Validate
{
    protected $rule = [
        'username'       => 'require|unique:admin',
        'password'        => 'require|confirm',
        'phone'           => 'require',
        'nickname'       => 'require',
        'thumb'          => 'require',
        'group_id'          => 'require',
        'id'              => 'require'
        'status'              => 'require'
    ];

    protected $message = [
        'username.require'       => '用户名不能为空',
        'password.require'        => '密码不能为空',
        'password.confirm'        => '两次密码不一致',
        'username.unique'      => '同样的记录已经存在!',
        'phone.require'         => '手机不能为空',
        'nickname.require'      => '昵称不能为空',
        'thumb.require'      => '头像不能为空',
        'group_id.require'      => '至少要选择一个分组',
        'id.require'      => '缺少更新条件',
        'status.require'      => '状态为必选',
    ];

    protected $scene = [
        'add' => ['phone', 'nickname', 'thumb', 'group_id', 'password', 'username', 'status'],
        'edit' => ['phone', 'nickname', 'thumb', 'group_id', 'id', 'username.unique', 'status'],
    ];
}