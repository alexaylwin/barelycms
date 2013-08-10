<?php

class FileIO
{
	
	public function __construct()
	{
	}
	
	/**
	 * Only pass in absolute file paths
	 */
	public function readFile($path)
	{
		//echo '>>>>>>>>' . $path;
		if($path == NULL || $path == '')
		{
			return '';
		}
		//'../container_content/pages/' . $page . '/' . $container;
		// if(!file_exists($path))
		// {
			// return '';
		// }
		$filelength = filesize($path);
		if($filelength == 0)
		{
			return '';
		}
		$fhandle = fopen($path, 'r');
		if($fhandle == NULL)
		{
			return '';
		}
		$text = fread($fhandle, $filelength);
		return $text;
	}
	
	public function writeFile($path, $data)
	{
		if($path == NULL || $path == '')
		{
			return '';
		}
		$fhandle = fopen($path, 'w');
		if($fhandle == NULL)
		{
			return '';
		}
		$res = fwrite($fhandle, $data);
		return $res;
	}
	
}

?>