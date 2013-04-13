<?php
class FrameworkController
{
	public static function loadsite()
	{
		//For now, only support one site
		$site = new Site('default');
		
		return $site;
	}
}
?>