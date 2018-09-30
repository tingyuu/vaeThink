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
namespace app\common\model;
use think\Db;
use think\Model;
class SendSms extends Model
{
	public function SendSms($phone,$name,$param,$type="normal",$code="SMS_136867253")
	{
	    // 配置信息
	    import('dayu.top.TopClient');
	    import('dayu.top.TopLogger');
	    import('dayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
	    import('dayu.top.ResultSet');
	    import('dayu.top.RequestCheckUtil');
	    
	    $c = new \TopClient();
	    $c ->appkey = config('dayu.appkey');
	    $c ->secretKey = config('dayu.secretKey');

	    $req = new \AlibabaAliqinFcSmsNumSendRequest();
	    //公共回传参数，在“消息返回”中会透传回该参数。非必须
	    $req ->setExtend("");
	    //短信类型，传入值请填写normal
	    $req ->setSmsType($type);
	    //短信签名，传入的短信签名必须是在阿里大于“管理中心-验证码/短信通知/推广短信-配置短信签名”中的可用签名。
	    $req ->setSmsFreeSignName($name);
	    //短信模板变量，传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。
	    $req ->setSmsParam($param);
	    //短信接收号码。支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。
	    $req ->setRecNum($phone);
	    //短信模板ID，传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。
	    $req ->setSmsTemplateCode($code);
	    //发送
	    $resp = $c ->execute($req);
	}
}