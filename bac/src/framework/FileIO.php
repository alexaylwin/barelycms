<?php

class FileIO
{
	
	public function __construct()
	{
	}
	
	/**
	 * This function returns the value of a file
	 * Only pass in absolute file paths
	 */
	public function readFile($path)
	{
		if($path == NULL || $path == '')
		{
			return '';
		}
		if(!file_exists($path))
		{
			return '';
		}
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
	
	/**
	 * This function returns all the files (NOT folders) inside
	 * a directory.
	 */
	public function getDirectoryFiles($path)
	{
		$returnFiles = array();
		$files = scandir($path);
		foreach($files as $file)
		{
			if(!is_dir($path . $file) && $file != '.gitignore' && $file != '.' && $file != '..')
			{
				$returnFiles[] = $file;
			}
		}
		
		return $returnFiles;
	}
	
	/**
	 * This function writes a file. 
	 * Only pass in absolute paths
	 */
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
	
	/**
	 * This function deletes a file.
	 * Only pass in absolute paths.
	 */
	public function deleteFile($path)
	{
		$res = unlink($path);
		return $res;		
	}
	
	/**
	 * This function deletes an entire directory.
	 * Only pass in absolute paths.
	 */
	public function deleteDirectory($path, $force)
	{
		if($force)
		{
			$content = scandir($path);
			unset($content[0]);
			unset($content[1]);

			//TODO: is there a case where this would fail halfway through? 
			// there may be a need for a 'safe delete' where files could be
			// recovered if needed
			foreach ($content as $file) {
				$success = $this->deleteFile($path . '/' . $file);
				if(!$success)
				{
					return false;
				}
			}
		}	
		$res = rmdir($path);
		return $res;
	}
	
	/**
	 * This function checks to see if a file exists.
	 * Only pass in absolute paths.
	 */
	public function fileExists($path)
	{
		return file_exists($path);
	}
	
}

?>