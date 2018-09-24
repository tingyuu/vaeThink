<?php
namespace vae;

class start
{
	public static $classMap = array();

	static public function run()
	{	
	}

	static public function load($class)
	{
		//自动加载类库
		if(isset($classMap[$class])){
			return true;
		} else {
			$class = str_replace('\\', '/', $class);
			$file = VAE_ROOT . 'listenrain/' .  $class . '.php';
			if(is_file($file)) {
				include $file;
				self::$classMap[$class] = $class;
			} else {
				return false;
			}
		}
	}
}