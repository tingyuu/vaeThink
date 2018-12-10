<?php
// +----------------------------------------------------------------------
// | vaeThink [ Programming makes me happy ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://www.vaeThink.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 听雨 < 389625819@qq.com >
// +----------------------------------------------------------------------

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

//读取指定权限分组详情
function vae_get_admin_group_info($id){
    $group = \think\Db::name('admin_group')->where(['id'=>$id])->find();
    $group['rules'] = explode(',',$group['rules']);
    $group['menus'] = explode(',',$group['menus']);
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

function vae_list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'list', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[$data[$pk]] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][$data[$pk]] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

//菜单父子关系排序，用于后台菜单DOM
function vae_set_admin_menu(){
    if(\think\Cache::tag('VAE_ADMIN_MENU')->get('menu'.vae_get_login_admin('id'))) {
        $list = \think\Cache::tag('VAE_ADMIN_MENU')->get('menu'.vae_get_login_admin('id'));
    } else {
        $adminGroup = \think\Db::name('admin_group_access')->where([
            'uid' => vae_get_login_admin('id')
        ])->column('group_id');
        $adminMenu = \think\Db::name('admin_group')->where([
            'id' => ['IN',$adminGroup]
        ])->column('menus');
        $adminMenus = [];
        foreach ($adminMenu as $k => $v) {
            $v = explode(',',$v);
            $adminMenus = array_merge($adminMenus,$v);
        }
        $menu = \think\Db::name('admin_menu')->where([
            'id' => ['IN',$adminMenus]
        ])->order('order asc')->select();
        $list = vae_list_to_tree($menu);
        \think\Cache::tag('VAE_ADMIN_MENU')->set('menu'.vae_get_login_admin('id'),$list);
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
    //上传开始前的钩子
    vae_set_hook('upload_begin',$file);
    $info = $file->rule('sha1')->move(VAE_ROOT . 'public' . DS . 'upload' . DS . $module . DS . $use);
    if($info) {
        //文件上传成功后的钩子
        vae_set_hook('upload_end',$file);
        $res['code'] = 1;
        $res['data'] = DS . 'upload' . DS . $module . DS . $use . DS . $info->getSaveName();
        return $res;
    } else {
        // 上传失败获取错误信息
        return vae_assign(0,'上传失败：'.$file->getError());
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
        $vaeIsInstalled = file_exists(VAE_ROOT . 'data/install.lock');
    }
    return $vaeIsInstalled;
}

//发邮件
function vae_send_email($to,$title,$content=""){
    $config = vae_get_config('emailconfig');
    if(NULL == $config) {
        return vae_assign(0,'请先在系统->配置->邮箱配置中配置您的SMTP信息且完成提交');
    }

    if(empty($content) and empty($config['template'])) {
        return vae_assign(0,'请提供邮件要发送的内容');
    }

    $content = empty($content) ? $config['template'] : $content;

    $toemail = $to;//定义收件人的邮箱

    $mail = new \vae\PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();// 使用SMTP服务
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = $config['smtp'];// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = $config['username'];// 发送方的QQ邮箱用户名，就是自己的邮箱名
    $mail->Password = $config['password'];// 发送方的邮箱密码，不是登录密码,是qq的第三方授权登录码,要自己去开启,在邮箱的设置->账户->POP3/IMAP/SMTP/Exchange/CardDAV/CalDAV服务 里面
    $mail->SMTPSecure = "ssl";// 使用ssl协议方式,
    $mail->Port = $config['port'];// QQ邮箱的ssl协议方式端口号是465/587

    $mail->setFrom($config['email'],$config['from']);// 设置发件人信息，如邮件格式说明中的发件人,
    $mail->addAddress($toemail,'亲');// 设置收件人信息，如邮件格式说明中的收件人
    $mail->addReplyTo($to,"Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
    $mail->IsHTML(true); //支持html格式内容
    //$mail->addCC("xxx@163.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
    //$mail->addBCC("pw9188@126.com");// 设置秘密抄送人(这个人也能收到邮件)
    //$mail->addAttachment("bug0.jpg");// 添加附件


    $mail->Subject = $title;// 邮件标题
    $mail->Body = $content;// 邮件正文
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

    if(!$mail->send()){// 发送邮件
         echo "Message could not be sent.";
         return "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
    }else{
         return true;
    }
}

//取系统配置
function vae_get_config($key)
{
    return \think\Config::get($key);
}

//系统信息
function vae_get_system_info($key)
{
    $system = [
        'os' => PHP_OS,
        'php' => PHP_VERSION,
        //'mysql' => mysql_get_server_info(),
        'upload_max_filesize' => get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件",
        'max_execution_time' => get_cfg_var("max_execution_time")."秒 ",
    ];
    if(empty($key)) {
        return $system;
    } else {
        return $system[$key];
    }
}

//获取插件类的类名
function vae_get_plugin_class($name)
{
    $name      = ucwords($name);
    $plugin = \think\Loader::parseName($name, 0, true);
    $className     = "plugin\\{$plugin}\\{$name}Index";
    return $className;
}

//设置钩子
function vae_set_hook($hook, &$params = null, $extra = null)
{
    return \think\Hook::listen($hook, $params, $extra = null);
}

//设置一个钩子
function vae_set_hook_one($hook, &$params = null, $extra = null)
{
    return \think\Hook::listen($hook, $params, $extra, true);
}

//读取导航列表,用于后台
function vae_get_nav($nav_id){
    $nav = \think\Db::name('NavInfo')->where('nav_id',$nav_id)->order('order asc')->select();
    return $nav;
}

//读取导航列表，用于前台
function vae_get_navs($name){
    if(!cache('VAE_NAV'.$name)) {
        $nav_id = \think\Db::name('Nav')->where(['name'=>$name,'status'=>1])->value('id');
        if(empty($nav_id)){
            return '';
        }
        \think\Cache::tag('VAE_NAV')->set('VAE_NAV'.$name,\think\Db::name('NavInfo')->where(['nav_id'=>$nav_id,'status'=>1])->select());
    }
    $navs = cache('VAE_NAV'.$name);
    
    return $navs;
}


/**
 * 获取URL,计算参数
 * @param $url
 * @param array $param
 */
function vae_get_route_url($params = [], $url = '')
{
    $request = \think\Request::instance();
    $get = $request->param();
    foreach ($get as $urlparam => $value) {
        if (strpos($urlparam, $request->action())) {
            unset($get[$urlparam]);
        } else {
            $get[$urlparam] = urldecode($value);
        }
    }

    if (is_array($params)) {
        $get = array_merge($get, $params);
    }
    if (empty($url)) {
        return url($request->action(), $get);
    } else {
        return url($url, $get);
    }

}

//发短信
function vae_send_sms($phone,$param,$code,$type="normal")
{
    // 配置信息
    include VAE_LTR."dayu/top/TopClient.php";
    include VAE_LTR."dayu/top/TopLogger.php";
    include VAE_LTR."dayu/top/request/AlibabaAliqinFcSmsNumSendRequest.php";
    include VAE_LTR."dayu/top/ResultSet.php";
    include VAE_LTR."dayu/top/RequestCheckUtil.php";
    
    $c = new \TopClient();
    $conf = config('dayuconfig');
    $c ->appkey = $conf['appkey'];
    $c ->secretKey = $conf['secretkey'];

    $req = new \AlibabaAliqinFcSmsNumSendRequest();
    //公共回传参数，在“消息返回”中会透传回该参数。非必须
    $req ->setExtend("");
    //短信类型，传入值请填写normal
    $req ->setSmsType($type);
    //短信签名，传入的短信签名必须是在阿里大于“管理中心-验证码/短信通知/推广短信-配置短信签名”中的可用签名。
    $req ->setSmsFreeSignName($conf['FreeSignName']);
    //短信模板变量，传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。
    $req ->setSmsParam($param);
    //短信接收号码。支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。
    $req ->setRecNum($phone);
    //短信模板ID，传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。
    $req ->setSmsTemplateCode($code);
    //发送
    $resp = $c ->execute($req);
}

//读取轮播图，用于前台
function vae_get_slide($name)
{
    if(!cache('VAE_SLIDE'.$name)) {
        $slide_id = \think\Db::name('slide')->where(['name'=>$name,'status'=>1])->value('id');
        if(empty($nav_id)){
            return '';
        }
        \think\Cache::tag('VAE_SLIDE')->set('VAE_SLIDE'.$name,\think\Db::name('SlideInfo')->where(['slide_id'=>$slide_id,'status'=>1])->select());
    }
    $slides = cache('VAE_SLIDE'.$name);
    
    return $slides;
}