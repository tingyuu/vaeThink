<?php

namespace app\admin\validate;

use think\Validate;
use think\Db;

class AdminMenu extends Validate
{
    protected $rule = [
        'title'       => 'require|unique:admin_menu',
        'pid'        => 'require',
        'id'           => 'require',
        'field'       => 'require',
    ];

    protected $message = [
        'title.require'       => '名称不能为空',
        'pid.require'        => '父级菜单为必选',
        'title.unique'      => '同样的记录已经存在!',
        'id.require'         => '缺少更新条件',
        'filed.require'      => '缺少要更新的字段名',
    ];

    protected $scene = [
        'add'  => ['title', 'pid'],
        'edit' => ['id', 'field', 'title.unique'],
    ];
}