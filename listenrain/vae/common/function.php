<?php

//返回json格式的数据
function vae_assign($code=1, $msg="OK", $data=[], $url='', $httpCode=200, $header = [], $options = []){
    $res=['code'=>$code];
    $res['msg']=$msg;
    $res['url']=$url;
    if(is_object($data)){
        $data=$data->toArray();
    }
    $res['data']=$data;
    $response = \think\Response::create($res, "json",$httpCode, $header, $options);
    throw new \think\exception\HttpResponseException($response);
}

//针对layui数据列表的返回数据方法
function vae_assign_table($code=0, $msg='', $data, $httpCode=200, $header = [], $options = []){
    $res['code'] = $code;
    $res['msg'] = $msg;
    if(is_object($data)) {
        $data = $data->toArray();
    }
    if(!empty($data['total'])){
        $res['count'] = $data['total'];
    } else {
        $res['count'] = 0;
    }
    $res['data'] = $data['data'];
    $response = \think\Response::create($res, "json",$httpCode, $header, $options);
    throw new \think\exception\HttpResponseException($response);
}

//获取url参数
function vae_get_param($key=""){
    return \think\Request::instance()->param($key);
}

//随机字符串，默认长度10
function vae_set_salt($num = 10){
    $str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
    $salt = substr(str_shuffle($str), 10, $num);
    return $salt;
}

//获取后台模块当前登录用户的信息
function vae_get_login_admin($key=""){
    if(\think\Session::has('vae_admin')) {
        $vae_admin = \think\Session::get('vae_admin');
        if(!empty($key)) {
            if(isset($vae_admin[$key])) {
                return $vae_admin[$key];
            } else {
                return '';
            }
        } else {
            return $vae_admin;
        }
        return $vae_admin['id'];
    } else {
        return '';
    }
}

//获取指定管理员的信息
function vae_get_admin($id)
{
    $admin = \think\Db::name('admin')->where(['id'=>$id])->find();
    $admin['group_id'] = \think\Db::name('admin_group_access')->where(['uid'=>$id])->column('group_id');
    return $admin;
}

//读取后台菜单列表
function vae_get_admin_menu(){
    $menu = \think\Db::name('admin_menu')->order('order asc')->select();
    return $menu;
}

//读取权限节点列表
function vae_get_admin_rule(){
    $rule = \think\Db::name('admin_rule')->order('create_time asc')->select();
    return $rule;
}

//读取权限分组列表
function vae_get_admin_group(){
    $group = \think\Db::name('admin_group')->order('create_time asc')->select();
    return $group;
}

//读取制定权限分组详情
function vae_get_admin_group_info($id){
    $group = \think\Db::name('admin_group')->where(['id'=>$id])->find();
    $group['rules'] = explode(',',$group['rules']);
    return $group;
}

//读取文章分类列表
function vae_get_article_cate(){
    $cate = \think\Db::name('article_cate')->order('create_time asc')->select();
    return $cate;
}

//读取指定分类下的文章列表
function vae_get_article($cate_id=""){
    $where = array();
    if(!empty($cate_id)) {
        $where['article_cate_id'] = $cate_id;
    }
    $article = \think\Db::name('article')->where($where)->order('create_time desc')->paginate(\think\Config::get('paginate.list_rows'));
    return $article;
}

//读取指定文章的详情
function vae_get_article_info($id)
{
    $article = \think\Db::name('article')->where(['id'=>$id])->find();
    if(empty($article)) {
        return show(0,'文章不存在');
    }
    return $article;
}

//递归排序
function vae_set_recursion($result,$pid=0,$format="L "){
    /*记录排序后的类别数组*/
    static $list=array();
 
    foreach ($result as $k => $v){
        if($v['pid']==$pid){
            if($pid!=0){
                $v['title']=$format.$v['title'];
            }
            /*将该类别的数据放入list中*/
            $list[]=$v;
            vae_set_recursion($result,$v['id'],"  ".$format);
        }
    }
 
    return $list;
}

//菜单父子关系排序，用于后台菜单dom
function vae_set_admin_menu(){
    if(\think\Cache::get('admin_menu')) {
        $list = \think\Cache::get('admin_menu');
    } else {
        $menu = \think\Db::name('admin_menu')->order('order asc')->select();
        $list = array();
        //先找出顶级菜单
        foreach ($menu as $k => $v) {
            if($v['pid'] == 0) {
                $list[$k] = $v;
            }
        }
        //通过顶级菜单找到下属的子菜单
        foreach ($list as $k => $val) {
            foreach ($menu as $key => $v) {
                if($v['pid'] == $val['id']) {
                    $list[$k]['list'][] = $v;
                }
            }
        }
        //三级菜单
        foreach ($list as $k => $val) {
            if(isset($val['list'])) {
                foreach ($val['list'] as $ks => $vals) {
                    foreach ($menu as $key => $v) {
                        if($v['pid'] == $vals['id']) {
                            $list[$k]['list'][$ks]['list'][] = $v;
                        }
                    }
                }
            }
        }
        \think\Cache::set('admin_menu',$list);
    }
    return $list;
}

//文件上传
function vae_upload($module,$use){
    if(request()->file('file')){
        $file = request()->file('file');
    }else{
        $res['code']=0;
        $res['msg']='没有上传文件';
        return $res;
    }
    $info = $file->rule('sha1')->move(VAE_ROOT . 'public' . DS . 'upload' . DS . $module . DS . $use);
    if($info) {
        $res['code'] = 1;
        $res['data'] = DS . 'upload' . DS . $module . DS . $use . DS . $info->getSaveName();
        return $res;
    } else {
        // 上传失败获取错误信息
        return show(0,'上传失败：'.$file->getError());
    }
}

//vaeThink加密方式
function vae_set_password($pwd, $salt){
    return md5(md5($pwd.$salt).$salt);
}

//判断vaeThink是否完成安装
function vae_is_installed()
{
    static $vaeIsInstalled;
    if (empty($vaeIsInstalled)) {
        $vaeIsInstalled = file_exists(VAE_ROOT . 'public/install.vae');
    }
    return $vaeIsInstalled;
}