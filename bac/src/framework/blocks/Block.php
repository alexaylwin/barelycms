<?php
/**
 * This class represents a generic block, and defines the common interface for all blocks. 
 */

abstract class Block
{
	/**
	 * This is the block ID, typically used in the bucket
	 */
	protected $blockid;
	
	/**
	 * Return the type of block
	 */
	protected $blocktype;
	
	/**
	 * Bucket id of the containing bucket
	 */
	protected $bucketid;
	
	protected $value;
	
	/**
	 * This function returns the value of the block - however it is defined
	 */
	public abstract function getValue();
	
	public abstract function setValue($new_value);
	
	/**
	 * Getters and Setters
	 */
	public function getBlockId()
	{
		return $this->blockid;
	}
	
	public function setBlockId($new_blockid)
	{
		$this->blockid = $new_blockid;
	}
	
	public function setBucketId($new_bucketid)
	{
		$this->bucketid = $new_bucketid;
	}
	
	public function getBucketId()
	{
		return $this->bucketid;
	}
	
	public function getBlockType()
	{
		return $this->blocktype;
	}
	
	public function setBlockType($new_blocktype)
	{
		$this->blocktype = $new_blocktype;
	}
	
	public function saveBlock()
	{
		
		$io = new FileIO();
		//Build the file name from the bucket path (includes the bucket extension)
		//and the block id.
		$filename = Constants::GET_PAGES_DIRECTORY() . '/' . $this->getBucketId() . '/' . $this->getBlockId() . '.incl';
		
		$serialized = serialize($this);
		
		$io = new FileIO();
		$io->writeFile($filename, $serialized);
	}
	
	
	
}



?>