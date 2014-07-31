<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class BucketsHandler extends RequestHandler
{
	
	protected function handleGet()
	{
		$framework = new FrameworkController();
		$site = $framework->getSite();
		$bucketlist = $site -> getAllBuckets();
		
		$maxblocks = 0;
		foreach($bucketlist as $bucket)
		{
			$blocklist = $bucket->getAllBlocks();
			if(count($blocklist) > $maxblocks)
			{
				$maxblocks = count($blocklist);
			}
		}

		$ret['bucketlist'] = $bucketlist;
		$ret['maxblocks'] = $maxblocks;
		return $ret;
	}
	
	protected function handlePost()
	{
		
	}
	
	/**
	 * This function is to support saving bucket config changes
	 * via Ajax
	 */
	protected function handleAjax()
	{
		$data = false;
		$data['success'] = 0;
		if(isset($this->post['pageurl']) && isset($this->post['bucketid']))
		{
			if(!empty($this->post['pageurl']))
			{
				$framework = new FrameworkController();
				$site = $framework->getSite();
				$bucket = $site->getBucket($this->post['bucketid']);
				$bucket->setLiveUrl($this->post['pageurl']);
				$data['success'] = $bucket->writeConfig();
				$data['liveUrl'] = $bucket->getLiveUrl();
				$data['bucketId'] = $bucket->getBucketId();
			}
		}
		
		if(isset($this->post['newblockid']) && isset($this->post['bucketid']))
		{
			if(!empty($this->post['newblockid']))
			{
				$framework = new FrameworkController();
				$site = $framework->getSite();
				if($site->hasBucket($this->post['bucketid']))
				{
					$bucket = $site->getBucket($this->post['bucketid']);
					$newblockConfig = Array(
						"type" => BlockTypes::Text,
						"blockid" => $this->post['newblockid'],
						"bucketid" => $bucket->getBucketId()
					);
					$factory = new BlockFactory();
					$newblock = $factory->build($newblockConfig);
					$bucket->addBlock($newblock);
					$data['success'] = 1;
				}
				
			}
		}
		
		$ret['ajax'] = true;
		$ret['data'] = $data;
		return $ret;
	}
}
?>