<?php

/**
	This class implements a bucket for holding text blocks.

**/
public class TextBucket extends Bucket
{
	
	//This creates a new block from a block id
	public function createBlock($blockid)
	{
		$newblock = new TextBlock($this->bucketid, $blockid);
		$this->addBlock($newblock);
	}
	
	//This reads a set of blocks from the filesystem and puts them into the blocklist
	public function loadBlock($blockid)
	{
		if(!empty($blockid))
		{
			$blockid = explode('.', $blockid);
			//TODO: inspect for block type and call the right constructor
			$new_b = new TextBlock($this -> bucketid, $blockid[0]);
			$this -> blocklist[$blockid[0]] = $new_b;
		}			

	}
		
	//This parses the bucket config for bucket specific configuration
	protected function parseConfig($configString)
	{
		
	}
	
	//This is called from the constructor, to apply configuration properties
	protected function applyConfig()
	{
		
	}
	
	//This saves the configuration
	protected function writeConfig($configString)
	{
		
	}
	
}

?>