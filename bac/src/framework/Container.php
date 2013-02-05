<?php

class Container
{
	private $value;
	private $containerid;
	private $filename;
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function getContainerId()
	{
		return $this->containerid;
	}
	
	/**
	 * This constructor accepts a page path and a container id.
	 * The page path should be the absolute file name of the script
	 * file that has a container on it.
	 */
	public function __construct($page_path, $container_id)
	{
		$io = new FileIO();
		
		//Build the file name from the page path (includes the page extension)
		//and the container id.
		$fullname = explode('.', $page_path);
		$pagename = $fullname[0];
		//$filename = '../container_content/pages/' . $pagename . '/' . $container_id . '.incl';
		$filename = Constants::GET_PAGES_DIRECTORY() . '/' . $pagename . '/' . $container_id . '.incl';
		$this->filename = $filename;
		
		
		$container_value = $io->readFile($filename);
		$this->value = $container_value;
		$this->containerid = $container_id;
	}
	
	public function setValue($new_value)
	{
		$this->value = $new_value;
		$io = new FileIO();
		$io->writeFile($this->filename, $new_value);
	}
	
	
}



?>