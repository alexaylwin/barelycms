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
		//TODO: right now, the block is only saved after the value is changed - not any other properties.
		$this->value = $new_value;
		$this->saveBlock();
	}
	
	/**
	 * This constructor accepts a bucket path and a bucket id.
	 * The bucket path should be the absolute file name of the script
	 * file that has a container on it.
	 */
	public function __construct($blockid, $bucketid)
	{	
		//Dont use the setters, so that we only call saveBlock once
		$this->setBlockId($blockid);
		$this->setBlockType(BlockTypes::Text);
		$this->setBucketId($bucketid);
		$this->saveBlock();
	}
	
	public function render($renderProperties)
	{
		return $this->getValue();
	}
}

?>