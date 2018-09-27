<?php
namespace plugin\chart;
use vae\lib\Plugin;
class ChartPlugin extends Plugin
{
	public function run(&$params)
	{
		return $this->fetch(__DIR__.'/view/main.html');
	}
}