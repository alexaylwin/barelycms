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
		$io = new FileIO();
		$io->writeFile($this->filename, $new_value);
	}
	
	/**
	 * This constructor accepts a bucket path and a container id.
	 * The bucket path should be the absolute file name of the script
	 * file that has a container on it.
	 */
	public function __construct($bucketid, $blockid)
	{
		$io = new FileIO();
		
		//Build the file name from the bucket path (includes the bucket extension)
		//and the block id.
		$filename = Constants::GET_PAGES_DIRECTORY() . '/' . $bucketid . '/' . $blockid . '.incl';
		$this->filename = $filename;
		$block_value = $io->readFile($filename);
		$this->setValue($block_value);
		$this->setBlockId($blockid);
		$this->blocktype = BlockTypes::Text;
	}
	
	public function render($renderProperties)
	{
		return $this->getValue();
	}
}

?>