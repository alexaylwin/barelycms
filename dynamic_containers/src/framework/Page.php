<?php
class Page
{
	private $pageid;
	private $containerlist;
	
	public function __construct($page)
	{
		$this->pageid = $page;
		$this->loadAllContainers();
	}
	
	public function getPageId()
	{
		return $this->pageid;
	}
	
	/**
	 * This returns the container with the given 
	 * cotnainer id or null if it doesn't exist
	 */
	public function getContainer($containerid)
	{
		return $this->containerlist[$containerid];
	}
	
	public function getAllContainers()
	{
		return $this->containerlist;
	}
	
	/**
	 * This loads all the pages containers into
	 * it's container array
	 */
	public function loadAllContainers()
	{
		//$containers = scandir('../container_content/pages/' . $this->pageid);
		$containers = scandir('dynamic_containers/container_content/pages/' . $this->pageid);
		//print_r($containers);
		unset($containers[0]);
		unset($containers[1]);
		
		foreach($containers as $containerid)
		{
			$containerid = explode('.', $containerid);
			$new_c = new Container($this->pageid . '.php', $containerid[0]);
			$this->containerlist[$containerid[0]] = $new_c;
		}
	}
}
?>
