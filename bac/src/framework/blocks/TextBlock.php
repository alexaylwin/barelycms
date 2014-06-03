<?php
/**
 * TextBlock implements a block with generic text
 */
class TextBlock extends Block implements Renderable
{

	public function getValue()
	{
		return $this->value;
	}
	
	public function setValue($new_value)
	{
		$this->value = $new_value;
		$this->saveBlock();
	}
	
	/**
	 * This constructor accepts a bucket path and a container id.
	 * The bucket path should be the absolute file name of the script
	 * file that has a container on it.
	 */
	public function __construct($bucketid, $blockid)
	{
		//$io = new FileIO();
		
		//Build the file name from the bucket path (includes the bucket extension)
		//and the block id.
		//$filename = Constants::GET_PAGES_DIRECTORY() . '/' . $bucketid . '/' . $blockid . '.incl';
		//$this->filename = $filename;
		//$block_value = $io->readFile($filename);
		//$this->setValue($block_value);
		
		//Dont use the setters, so that we only call saveBlock once
		$this->setBlockId($blockid);
		$this->setBucketId($bucketid);
		$this->setBlockType(BlockTypes::Text);
		$this->saveBlock();
	}
	
	public function render($renderProperties)
	{
		return $this->getValue();
	}
}

?>