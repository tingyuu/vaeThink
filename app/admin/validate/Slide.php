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

class Slide extends Validate
{
    protected $rule = [
        'title'       => 'require|unique:slide',
        'name'        => 'require|unique:slide',
        'id'          => 'require',
        'status'      => 'require',
        'img'         => 'require',
        'slide_id'    => 'require',
    ];

    protected $message = [
        'title.require'           => '标题不能为空',
        'name.require'            => '标识不能为空',
        'title.unique'            => '同样的记录已经存在!',
        'name.unique'             => '同样的记录已经存在!',
        'id.require'              => '缺少更新条件',
        'status.require'          => '状态为必选',
        'img.require'             => '请上传图片',
        'slide_id.require'        => '缺少换灯组ID',
    ];

    protected $scene = [
        'add'       => ['title', 'name', 'status'],
        'edit'      => ['id', 'title', 'name', 'status'],
        'addInfo'   => ['title', 'img', 'status', 'slide_id'],
        'editInfo'  => ['title', 'img', 'status', 'id'],
    ];
}