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

class AdminRule extends Validate
{
    protected $rule = [
        'title'       => 'require|unique:admin_rule',
        'name'        => 'require|unique:admin_rule',
        'pid'         => 'require',
        'id'          => 'require',
        'field'       => 'require',
    ];

    protected $message = [
        'title.require'      => '名称不能为空',
        'name.require'       => '规则不能为空',
        'pid.require'        => '父级节点为必选',
        'title.unique'       => '同样的记录已经存在!',
        'name.unique'        => '同样的规则已经存在!',
        'id.require'         => '缺少更新条件',
        'filed.require'      => '缺少要更新的字段名',
    ];

    protected $scene = [
        'add'  => ['title', 'pid', 'name'],
        'edit' => ['id', 'field' ,'title.unique','ame.unique'],
    ];
}