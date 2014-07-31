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
		
		$framework = new FrameworkController();
		$site = $framework->getSite();
				
		if(isset($this->post['pageurl']) && isset($this->post['propertiesBucketId']))
		{
			if(!empty($this->post['pageurl'])  && $site->hasBucket($this->post['propertiesBucketId']))
			{
				$bucket = $site->getBucket($this->post['propertiesBucketId']);
				$bucket->setLiveUrl($this->post['pageurl']);
				$data['success'] = $bucket->writeConfig();
				$data['liveUrl'] = $bucket->getLiveUrl();
				$data['bucketId'] = $bucket->getBucketId();
			}
		}
		
		if(isset($this->post['newblockid']) && isset($this->post['addBlockBucketId']))
		{
			if(!empty($this->post['newblockid']) && $site->hasBucket($this->post['addBlockBucketId']))
			{
				$bucket = $site->getBucket($this->post['addBlockBucketId']);
				$newblockConfig = Array(
					"type" => BlockTypes::Text,
					"blockid" => $this->post['newblockid'],
					"bucketid" => $bucket->getBucketId()
				);
				$factory = new BlockFactory();
				$newblock = $factory->build($newblockConfig);
				$data['success'] = $bucket->addBlock($newblock);;
		}
		}
		
		if(isset($this->post['deleteBlock']) && isset($this->post['deleteBlockBlockId']) && isset($this->post['deleteBlockBucketId']))
		{
			if(!empty($this->post['deleteBlockBlockId'])  && $site->hasBucket($this->post['deleteBlockBucketId']))
			{
				$bucket = $site->getBucket($this->post['deleteBlockBucketId']);
				if($bucket->hasBlock($this->post['deleteBlockBlockId']))
				{
					if($bucket->removeBlock($this->post['deleteBlockBlockId']))
					{
						$data['success'] = 1;
					} else {
						$data['success'] = 0;
					}
				}
			}
		}
		
		$ret['ajax'] = true;
		$ret['data'] = $data;
		return $ret;
	}
}
?>