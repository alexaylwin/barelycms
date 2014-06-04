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
	
	public function __construct($config)
	{

		$this->bucketid = $config['bucketid'];
		
		//If this bucket already exists in storage, then just load it
		if($this->bucketExists())
		{
			$this->config = $this->readConfig($this->getBucketId());

			$this->applyConfig();
			$this->bucketid = $this->config['bucketid'];
			$this->type = $this->config['type'];
			
		} else {
			//Otherwise, make a new directory and config file
			$this->config = $config;

			$this->applyConfig();
			$this->bucketid = $this->config['bucketid'];
			$this->type = $this->config['type'];
			
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->getBucketId();			
			$res = mkdir($path);
			if (!$res) 
			{
				//error while trying to make the directory
				return;
			} else {
				$this->writeConfig();
			}
		}
		
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
		$blocks = scandir(Constants::GET_PAGES_DIRECTORY() . '/' . $this->getBucketId());
		unset($blocks[0]);
		unset($blocks[1]);
		
		foreach ($blocks as $blockfile)
		{
			if($blockfile != '.bucket')
			{
				$this->loadBlock(Constants::GET_PAGES_DIRECTORY() . '/' . $this->getBucketId() . '/' . $blockfile);
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
				$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->getBucketId() . "/" . $blockid . ".incl";
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
	
	public function readConfig($configString)
	{
		$config;
		$configFileName = Constants::GET_PAGES_DIRECTORY() . '/' . $this->getBucketId() . '/.bucket';
		$io = new FileIO();
		if($io->fileExists($configFileName))
		{
			$serializedConfig = $io->readFile($configFileName);
			$config = unserialize($serializedConfig);
		}
		return $config;
	}
	
	//Use reflection to get the properties that need to be 
	//written to the configuration
	public function writeConfig()
	{

		$properties = $this->getConfigProperties();
		
		//Add the id and type, as these will always be written
		$config['bucketid'] = $this->getBucketId();
		$config['type'] = $this->getType();
				
		//Instantiate an instance of ReflectionClass, on the $this class type
		$reflectionClass = new ReflectionClass(get_class($this));		
		foreach($properties as $prop)
		{
			$val = $reflectionClass->getProperty($prop)->getValue($this);
			$config[$prop] = $val;
		}

		$io = new FileIO();
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->getBucketId() . "/.bucket";
		$serializedConfig = serialize($config);
		$io->writeFile($path, $serializedConfig);
		
		return true;
	}
	
	/**
	 * This method checks to see if this bucket already exists in the directory or not.
	 */
	private function bucketExists()
	{
		$path = Constants::GET_PAGES_DIRECTORY() . "/" . $this->getBucketId() . "/.bucket";
		$io = new FileIO();
		return $io->fileExists($path);
	}

	public function getType()
	{
		return $this->type;
	}

	public abstract function createBlock($blockid);
	
	protected abstract function applyConfig();
	
	protected abstract function getConfigProperties();
		
}
?>