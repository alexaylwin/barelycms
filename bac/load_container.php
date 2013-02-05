<?php

	include_once('src/framework/classloader.php');
	function load_container($pagename, $container)
	{
		$site = FrameworkController::loadsite();
		$page = $site->getPage($pagename);
		$container = $page->getContainer($container);
		//echo $container->getValue();

	}	
	echo load_container($_GET['page'], $_GET['container']);
	
	
?>