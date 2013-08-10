<?php
class Site
{
	private $siteid;
	private $pagelist = array();
	
	public function __construct($site)
	{
		$this->siteid = $site;
		$this->loadAllPages();
	}
	
	public function getSiteId()
	{
		return $this->siteid;
	}
	
	/**
	 * This returns the container with the given 
	 * cotnainer id or null if it doesn't exist
	 */
	public function getPage($pageid)
	{
		try
		{
			if(isset($this->pagelist[$pageid]))
			{
				return $this->pagelist[$pageid];
			} else {
				return;
			}
		} catch (Exception $e) {
			return;
		}
	}
	
	public function getAllPages()
	{
		
		return $this->pagelist;
	}
	
	/**
	 * This loads all the pages containers into
	 * it's container array
	 */
	public function loadAllPages()
	{
		//$pages = scandir('../container_content/pages');
		$pages = scandir(Constants::GET_PAGES_DIRECTORY());
		$io = new FileIO();
	
		
		//These are the . and .. directories
		unset($pages[0]);
		unset($pages[1]);
		//print_r($pages);
				
		foreach($pages as $pageid)
		{
			$pageconfig = $io->readFile(Constants::GET_PAGES_DIRECTORY() . '/' . $pageid . '/.bacproperties');
			$new_page = new Page($pageconfig);
			$this->pagelist[$pageid] = $new_page;
		}
	}
	
	/**
	 * Adds a new page with name pageid. This checks first to see if the page
	 * exists. If not, it creates the directory and adds the page to this site.
	 */
	public function addPage($pageid, $liveurl = '')
	{
		$io = new FileIO();
		if(!isset($this->pagelist[$pageid]))
		{
		
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $pageid;
			if (!file_exists($path)) {
				//It doesn't exist, so create the directory
				$res = mkdir($path);
				if (!$res) 
				{
					//error while trying to make the directory
					return false;
				} else {
					$config = "id:" . $pageid . "|liveurl:" . $liveurl;
					if(!file_exists($path . "/.bacproperties"))
					{
						$io->writeFile($path . "/.bacproperties", $config);
					}
					$new_page = new Page($config);
					$this->pagelist[$pageid] = $new_page;
					return true;
				}
			} elseif (file_exists($path) && !is_dir($path)) {
				//error, path exists and is not a directory
				return false;
			}
			
		} else {
			return false;
		}
	}
	
	/**
	 * Deletes the page from this site as well as the directory and any
	 * containers below it.
	 */
	public function removePage($pageid)
	{
		if(isset($this->pagelist[$pageid]))
		{
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $pageid;
			$res = rmdir($path);
			if (!$res) {
				return false;
			}
			unset($this->pagelist[$pageid]);
			return true;
		} else {
			return false;
		}
	}
}
?>
