<?php

//In here, define some constants that we'll use for configuration
class Constants
{
	//this we don't want, because the install directory is actually the website name
	//and doesn't have anything to do with BAC (and the user shouldn't have to specify it) 
	//we should be able to detect it
	//const INSTALL_DIRECTORY = 'barelycms';
	
	const BAC_DIRECTORY = 'bac';
	const CONTAINER_DIRECTORY = 'container_content';
	const PAGES_DIRECTORY = 'pages';
	const ADMIN_DIRECTORY = 'admin';
	const CONFIG_DIRECTORY = 'config';

	public static function GET_BAC_DIRECTORY()
	{
		self::getInstallDirectory();
		return Constants::getInstallDirectory() . '/' .Constants::BAC_DIRECTORY;
	}
	
	public static function GET_PAGES_DIRECTORY()
	{
		self::getInstallDirectory();
		return Constants::getInstallDirectory() . '/' .Constants::BAC_DIRECTORY . '/' . Constants::CONTAINER_DIRECTORY . '/' . Constants::PAGES_DIRECTORY;
	}
	
	public static function GET_CONFIG_DIRECTORY()
	{
		self::getInstallDirectory();
		return Constants::getInstallDirectory() . '/' . Constants::BAC_DIRECTORY . '/' . Constants::ADMIN_DIRECTORY . '/' . Constants::CONFIG_DIRECTORY; 
	}
	
	
	/**
	 * This function gets the installation directory, relative to the document root.
	 * We use it to build the paths to BAC content. 
	 */
	private static function getInstallDirectory()
	{
		//Return the 4th folder up from the current directory
		//if BAC hasn't been tampered with, this will be
		//the directory immediately above BAC
		$path = str_replace('\\', '/', __DIR__);
		$folders= explode('/', $path);
		
		$ret = '';
		foreach($folders as $f)
		{
			if($f == Constants::BAC_DIRECTORY)
			{
				break;
			} else {
				$ret = $ret . $f . '/';
			}
		}
		//echo $ret;
		
		return $ret;//trim($ret, '/');
	}
}


?>