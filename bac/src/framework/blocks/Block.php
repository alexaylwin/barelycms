<?php
/**
 * This class represents a generic block, and defines the common interface for all blocks. 
 */

abstract class Block
{
	/**
	 * This is the block ID, typically used in the bucket
	 */
	private $blockid;
	
	/**
	 * Return the type of block
	 */
	private $blocktype;
	
	/**
	 * Blocks are ultimately linked to a partcular file, which holds the block
	 * content. This property is the filename that this block represents
	 */
	private $filename;
	
	
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
	
	public function getBlockType()
	{
		return $this->blocktype;
	}
	
	public function setBlockType($new_blocktype)
	{
		$this->blocktype = $blocktype;
	}
	
		public function getFilename()
	{
		return $this->filename;
	}
	
	public function setFilename($new_filename)
	{
		$this->filename = $new_filename;
	}
	
	
	
}



?>