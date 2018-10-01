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
use vae\controller\AdminCheckAuth;

class HookController extends AdminCheckAuth
{
    public function index()
    {
        return view();
    }

    //列表
    public function getHookList()
    {
    	$param = vae_get_param();
        $where = array();
        if(!empty($param['keywords'])) {
            $where['id|name|desc'] = ['like', '%' . $param['keywords'] . '%'];
        }
        $rows = empty($param['limit']) ? \think\Config::get('paginate.list_rows') : $param['limit'];
        $hook = \think\Db::name('hook')->where($where)->order('id asc')->paginate($rows,false,['query'=>$param]);
    	return vae_assign_table(0,'',$hook);
    }
}
