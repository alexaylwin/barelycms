<?php
/**
	This is the generic bucket class, all other
	buckets will extend this class.
	
	The Bucket class is a heavy abstract class - it
	covers a lot of implementation details. Specifically,
	any code where the filesystem is accessed is handled here.
	This is to keep block storage consistent across block types,
	so that there are no unintended side effects with block or
	bucket loading.
	
	To create a new bucket type, extend this type, implementing the
	config methods, etc.
	TODO: finish this.
**/

abstract class Bucket {
	
	protected $bucketid;
	
	protected $blocklist;
	
	/**
	 * The config object contains meta data about the bucket in KVPs as
	 * defined by the bucket type.
	 */
	protected $config;
	
	protected $type;
	
	public function __construct($bucketConfig)
	{
		$this->config = $this->parseConfig($bucketConfig);
		$this->applyConfig();
		$this->bucketid = $this->config['bucketid'];
		$this->type = $this->config['type'];
		$this->loadBlocks();
	}
	
	public function hasBlock($blockid)
	{
		return isset($this->blocklist[$blockid]);
	}
	
	public function getBucketId()
	{
		return $this->bucketid;
	}
	
	public function hasBlocks(){
		return ($this->getBlockCount() > 0);
	}
	
	public function getBlockCount()
	{
		return (count($this->blocklist));
	}
	
	public function getBlock($blockid)
	{	
		try {
			$block = $this->blocklist[$blockid];
			return $block;
		} catch (Exception $e) {
			return;
		}
	}
	
	public function getAllBlocks()
	{
		return $this->blocklist;
	}
	
	public function loadBlocks()
	{
		$blocks = scandir(Constants::GET_PAGES_DIRECTORY() . '/' . $this -> bucketid);
		unset($blocks[0]);
		unset($blocks[1]);
		
		foreach ($blocks as $blockfile)
		{
			if($blockfile != '.bacproperties')
			{
				//$blockid = explode('.', $blockid);
				//$blockid = $blockid[0];
				$this->loadBlock(Constants::GET_PAGES_DIRECTORY() . '/' . $this -> bucketid . '/' . $blockfile);
			}
		}
	}

	private function loadBlock($blockfile)
	{
		$io = new FileIO();
		$serialized = $io->readFile($blockfile);
		$newblock = unserialize($serialized);
		$this->addBlock($newblock);
		
	}
	
	public function addBlock($newblock)
	{
		$this->blocklist[$newblock->getBlockId()] = $newblock;
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
	
	public function parseConfig($configString)
	{
		$config;
		
		$entries = explode("|", $configString);
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
	
	//Use reflection to get the properties that need to be 
	//written to the configuration
	public function writeConfig()
	{
		$properties = $this->getConfigProperties();
		
		//Add the id and type, as these will always be written
		$properties[] = "bucketid";
		$properties[] = "type";
		
		//Instantiate an instance of ReflectionClass, on the $this class type
		$reflectionClass = new ReflectionClass(get_class($this));
		
		$writestring = '';
		$first = true;
		
		foreach($properties as $prop)
		{
			$val = $reflectionClass->getProperty($prop)->getValue($this);
			if($first)
			{
				$writestring = $prop . ":" . rawurlencode($val);
			} else {
				$writestring .= "|" . $prop . ":" . rawurlencode($val);
			}
		}
		
		$io = new FileIO();
		
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->bucketid . "/.bacproperties";
		$io->writeFile($path, $writeString);
		
		return true;			
	}


	public abstract function createBlock($blockid);
	
	protected abstract function applyConfig();
	
	protected abstract function getConfigProperties();
		
}
?>