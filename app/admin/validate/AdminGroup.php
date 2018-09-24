<?php

namespace app\admin\validate;

use think\Validate;
use think\Db;

class AdminGroup extends Validate
{
    protected $rule = [
        'title'       => 'require|unique:admin_group',
        'id'          => 'require',
        'status'          => 'require'
    ];

    protected $message = [
        'title.require'       => '名称不能为空',
        'title.unique'      => '同样的记录已经存在!',
        'id.require'         => '缺少更新条件',
        'status.require'         => '状态为必选',
    ];

    protected $scene = [
        'add'  => ['title'],
        'edit' => ['id', 'title.require'],
    ];
}