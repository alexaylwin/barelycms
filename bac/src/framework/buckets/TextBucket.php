<?php

/**
	This class implements a bucket for holding text blocks.

**/
class TextBucket extends Bucket
{
	private $liveurl;
	
	//This creates a new block from a block id
	public function createBlock($blockid)
	{
		if(!$this->hasBlock($blockid))
		{
			$newblock = new TextBlock($this->getBucketId(), $blockid);
			$this->addBlock($newblock);
		}
	}
	
	//This reads a set of blocks from the filesystem and puts them into the blocklist
/*
	public function loadBlock($blockid)
	{
		if(!empty($blockid))
		{
			//TODO: inspect for block type and call the right constructor\
			//$new_b = new TextBlock($this->getBucketId(), $blockid);
			$new_block = 
			$this->addBlock($new_b);
		}

	}
*/
	
	//This is called from the constructor, to apply configuration properties
	protected function applyConfig()
	{
		if(isset($this->config['bucketid']))
		{
			$this -> bucketid = $this->config['bucketid'];
		}
		if(isset($this->config['liveurl']))
		{
			$this -> liveurl = $this->config['liveurl'];
		}
		
	}
	
	protected function getConfigProperties()
	{
		return array(
			"liveurl"
		);	
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
	
	
	public function getLiveUrl()
	{
		return $this->liveurl;
	}
	
	public function setLiveUrl($liveurl)
	{
		$this->liveurl = $liveurl;
	}
	
}

?>