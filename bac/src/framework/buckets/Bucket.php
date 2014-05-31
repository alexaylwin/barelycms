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
	
	private $bucketid;
	
	private $blocklist;
	
	/**
	 * The config object contains meta data about the bucket in KVPs as
	 * defined by the bucket type.
	 */
	private $config;
	
	private $type;
	
	public function __construct($bucketConfig)
	{
		$this->config = $this->parseConfig($bucketConfig);
		$this->applyConfig();
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
	
	public function getBlockCount()
	{
		return (count($this->blocklist));
	}
	
	public function getBlock($blockid)
	{
		try {
			$block = $this -> blocklist[$blockid];
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
		
		foreach ($blocks as $blockid) {
		{
			if($blockid != '.bacproperties')
			{
				$blockid = explode('.', $blockid);
				loadBlock($blockid);
				addBlock()
			}
		}
	}
	
	public function addBlock($newblock)
	{
		$blocklist[$newblock->getBlockId()] = $newblock;
	}

	public function removeBlock($blockid)
	{
		if(isset($blocklist[$blockid]))
		{
			unset($blocklist[$blockid]);
		}
	}


	public abstract function createBlock($blockid);
	
	public abstract function loadBlock($blockid);
		
	protected abstract function parseConfig($configString);
	
	protected abstract function applyConfig();
	
	protected abstract function writeConfig($configString);
		
}
?>