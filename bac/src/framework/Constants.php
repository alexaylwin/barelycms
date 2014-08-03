<?php
/**
 * Constants is a class which holds installation related constants,
 * including methods for fetching the relative paths to important
 * BAC folders.
 */

abstract class Constants
{
	
	const BAC_DIRECTORY = 'bac';
	const CONTAINER_DIRECTORY = 'container_content';
	const PAGES_DIRECTORY = 'pages';
	const ADMIN_DIRECTORY = 'admin';
	const CONFIG_DIRECTORY = 'config';
	const USERS_DIRECTORY = 'users';

	public static function GET_BAC_DIRECTORY()
	{
		return self::getInstallDirectory() . '/' .self::BAC_DIRECTORY;
	}
	
	public static function GET_PAGES_DIRECTORY()
	{
		return self::getInstallDirectory() . '/' .self::BAC_DIRECTORY . '/' . self::CONTAINER_DIRECTORY . '/' . self::PAGES_DIRECTORY;
	}
	
	public static function GET_CONFIG_DIRECTORY()
	{
		return self::getInstallDirectory() . '/' . self::BAC_DIRECTORY . '/' . self::ADMIN_DIRECTORY . '/' . self::CONFIG_DIRECTORY;
	}
	
	public static function GET_USERS_DIRECTORY()
	{
		return self::getInstallDirectory() . '/' . self::BAC_DIRECTORY . '/' . self::ADMIN_DIRECTORY . '/' . self::CONFIG_DIRECTORY . '/' . self::USERS_DIRECTORY;
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
		
		return $ret;
	}
}


?>