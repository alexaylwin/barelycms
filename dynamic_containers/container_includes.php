<?php
	include_once('src/framework/classloader.php');
	
	/*
	 * This function loads data for the referenced container
	 * from the appropriate flat file. 
	 */
	function load_container($container)
	{
		$fullname = basename($_SERVER['SCRIPT_FILENAME']);
		$fullname = explode('.', $fullname);
		$pagename = $fullname[0];
		//get the file handle
		
		$site = FrameworkController::loadsite();
		$page = $site->getPage($pagename);
		$container = $page->getContainer($container);
		return $container->getValue();
		
		/*
		 * $filename = dirname(__FILE__) . '\\container_content\\pages\\' . $pagename . '\\' . $container . '.incl';
		$fhandle = fopen($filename, 'r');
		$text = fread($fhandle, filesize($filename));
		return $text;
		 */
	}
?>
