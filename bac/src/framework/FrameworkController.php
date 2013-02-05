<?php
class FrameworkController
{
	public static function loadsite()
	{
		$site = new Site('default');
		
		return $site;
	}
}
?>