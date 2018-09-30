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

class Route extends Validate
{
    protected $rule = [
        'full_url'       => 'require|unique:route',
        'url'            => 'require|unique:route',
        'id'             => 'require',
        'status'         => 'require'
    ];

    protected $message = [
        'full_url.require'       => '完整url不能为空',
        'url.require'            => '要显示的url不能为空',
        'full_url.unique'        => '同样的记录已经存在!',
        'url.unique'             => '同样的记录已经存在!',
        'id.require'             => '缺少更新条件',
        'status.require'         => '状态为必选',
    ];

    protected $scene = [
        'add'  => ['full_url', 'url', 'status'],
        'edit' => ['id', 'full_url', 'url', 'status'],
    ];
}