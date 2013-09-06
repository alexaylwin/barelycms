<?php
class Bucket {
	private $bucketid;
	private $blocklist;
	private $liveurl;
	private $config;

	public function __construct($bucketconfig)
	{
		$this->config = $this->parseConfig($bucketconfig);
		if(isset($this->config['id']))
		{
			$this -> bucketid = $this->config['id'];
		}
		if(isset($this->config['liveurl']))
		{
			$this -> liveurl = $this->config['liveurl'];
		}
		$this -> loadAllBlocks();
	}
	
	public function getLiveUrl()
	{
		return $this->liveurl;
	}

	public function getBucketId() {
		return $this -> bucketid;
	}
	
	public function hasBlock($blockid)
	{
		return isset($this->blocklist[$blockid]);
	}

	public function hasBlocks() 
	{
		return (count($this -> blocklist) > 0);
	}

	/**
	 * This returns the container with the given
	 * cotnainer id or null if it doesn't exist
	 */
	public function getBlock($blockid) {
		try {
			$block = $this -> blocklist[$blockid];
			return $block;
		} catch (Exception $e) {
			return;
		}

	}

	public function getAllBlocks() {
		return $this -> blocklist;
	}

	/**
	 * This loads all the buckets blocks into
	 * it's block array
	 */
	public function loadAllBlocks() {
		$blocks = scandir(Constants::GET_PAGES_DIRECTORY() . '/' . $this -> bucketid);
		//print_r($containers);
		unset($blocks[0]);
		unset($blocks[1]);

		foreach ($blocks as $blockid) {
			if($blockid != '.bacproperties')
			{
				$blockid = explode('.', $blockid);
				$new_b = new Block($this -> bucketid . '.php', $blockid[0]);
				$this -> blocklist[$blockid[0]] = $new_b;
			}
		}
	}

	public function addBlock($blockid) {
		//TODO: use file IO for file writes
		if (!isset($this -> blocklist[$blockid])) {
			//make a path
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this -> bucketid . "/" . $blockid . ".incl";
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

			$this -> blocklist[$blockid] = new Block($this -> bucketid . '.php', $blockid);
			return true;
		} else {
			return false;
		}

	}

	public function removeBlock($blockid) 
	{
		if(isset($this->blocklist[$blockid]))
		{
			//delete this block
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->bucketid . "/" . $blockid . ".incl";
			$io = new FileIO();
			if(!$io->deleteFile($path))
			{
				return false;
			}
			unset($this->blocklist[$blockid]);
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
		$config = "id:" . rawurlencode($this->bucketid) . "|liveurl:" . rawurlencode($this->liveurl);
		
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->bucketid . "/.bacproperties";
		$io->writeFile($path, $config);
		
		return true;	
	}
}
?>
