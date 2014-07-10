<?php

/**
	This class implements a bucket for holding text blocks.

**/
class TextBucket extends Bucket
{
	public $liveurl;
	
	//This creates a new block from a block id
	public function createBlock($blockid)
	{
		return;
	}
/*
	public function createBlock($blockid)
	{
		if(!$this->hasBlock($blockid))
		{
			$newblock = new TextBlock($blockid);
			$newblock->setBucketId($this->getBucketId());
			$this->addBlock($newblock);
		}
	}*/

	
	//This is called from the constructor, to apply configuration properties
	protected function applyConfig()
	{
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