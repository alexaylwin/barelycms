<?php
class Site
{
	private $siteid;
	private $pagelist;
	
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
		if(isset($this->pagelist[$pageid]))
		{
			return $this->pagelist[$pageid];
		} else {
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
		$pages = scandir(Constants::GET_PAGES_DIRECTORY());//. '/container_content/pages');
		unset($pages[0]);
		unset($pages[1]);
		//print_r($pages);
		
		foreach($pages as $pageid)
		{
			$new_page = new Page($pageid);
			$this->pagelist[$pageid] = $new_page;
		}
	}
}
?>
