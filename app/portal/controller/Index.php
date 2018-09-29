<?php
namespace app\portal\controller;
use vae\PHPMailer\PHPMailer\PHPMailer;

class Index extends \vae\controller\ControllerBase
{
	public function hehe()
	{
		// $str = '<?php return ["name"=>"vaeThink","keywords"=>"vae,php"];';
		// file_put_contents(VAE_ROOT . "data/conf/webconfig.php",$str);
		dump(\think\Config::get('webconfig.name'));
	}
}