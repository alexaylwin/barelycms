<?php
class Page {
	private $pageid;
	private $containerlist;
	private $liveurl;
	private $config;

	public function __construct($pageconfig)
	{
		$this->config = $this->parseConfig($pageconfig);
		if(isset($this->config['id']))
		{
			$this -> pageid = $this->config['id'];
		}
		if(isset($this->config['liveurl']))
		{
			$this -> liveurl = $this->config['liveurl'];
		}
		$this -> loadAllContainers();
	}
	
	public function getLiveUrl()
	{
		return $this->liveurl;
	}

	public function getPageId() {
		return $this -> pageid;
	}
	
	public function hasContainer($containerid)
	{
		return isset($this->containerlist[$containerid]);
	}

	public function hasContainers() 
	{
		return (count($this -> containerlist) > 0);
	}

	/**
	 * This returns the container with the given
	 * cotnainer id or null if it doesn't exist
	 */
	public function getContainer($containerid) {
		try {
			$container = $this -> containerlist[$containerid];
			return $container;
		} catch (Exception $e) {
			return;
		}

	}

	public function getAllContainers() {
		return $this -> containerlist;
	}

	/**
	 * This loads all the pages containers into
	 * it's container array
	 */
	public function loadAllContainers() {
		$containers = scandir(Constants::GET_PAGES_DIRECTORY() . '/' . $this -> pageid);
		//print_r($containers);
		unset($containers[0]);
		unset($containers[1]);

		foreach ($containers as $containerid) {
			if($containerid != '.bacproperties')
			{
				$containerid = explode('.', $containerid);
				$new_c = new Container($this -> pageid . '.php', $containerid[0]);
				$this -> containerlist[$containerid[0]] = $new_c;
			}
		}
	}

	public function addContainer($containerid) {
		if (!isset($this -> containerlist[$containerid])) {
			//make a path
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this -> pageid . "/" . $containerid . ".incl";
			//if it doesn't exist, we can make it
			if (!file_exists($path)) {
				$fhandlew = fopen($path, 'w');
				$res = fwrite($fhandlew, "");
				if (!$res) {
					//error
					return false;
				}
			} else {
				return false;
			}

			$this -> containerlist[$containerid] = new Container($this -> pageid . '.php', $containerid);
			return true;
		} else {
			return false;
		}

	}

	public function removeContainer($containerid) 
	{
		if(isset($this->containerlist[$containerid]))
		{
		//delete this container
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->pageid . "/" . $containerid . ".incl";
		$res = unlink($path);
		if (!$res) {
			return false;
		}
		unset($this->containerlist[$containerid]);
		return true;
		} else {
			return false;
		}
	}
	
	public function canLiveEdit()
	{
		if(!empty($this->liveurl))
		{
			return true;
		} else {
			return false;
		}
	}
	
	public function setLiveUrl($liveurl)
	{
		$this->liveurl = $liveurl;
	}
	
	private function parseConfig($configstring)
	{
		$config;
		
		$entries = explode("|", $configstring);
		for($i = 0; $i < sizeof($entries); $i++)
		{
			$entry = $entries[$i];
			$kvp = explode(":", $entry);
			if(!empty($kvp[0]))
			{
				$config[$kvp[0]] = rawurldecode($kvp[1]);
			}			
		}
		return $config;
	}
	
	public function writeConfig()
	{
		$io = new FileIO();
		$config = "id:" . rawurlencode($this->pageid) . "|liveurl:" . rawurlencode($this->liveurl);
		
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->pageid . "/.bacproperties";
		$io->writeFile($path, $config);
		
		return true;	
	}
}
?>
