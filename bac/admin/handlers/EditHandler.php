<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Edit code behind file. This script is for the Page view. 
 */
class EditHandler extends RequestHandler
{
	
	protected function handleGet()
	{
		if(empty($this->get['block']) || empty($this->get['bucket']))
		{
			$ret['error'] = 'noblock';
			return $ret;
		}
		$site = FrameworkController::loadsite();
		
		$blockid = $this->get['block'];
		$bucketid = $this->get['bucket'];
		
		if($site->hasBucket($bucketid))
		{
			$bucket = $site -> getBucket($bucketid);	
		} else {
			$ret['error'] = 'noblock';
			return $ret;
		}
		
		if($bucket->hasBlock($blockid))
		{
			$block = $bucket -> getBlock($blockid);
		} else {
			$ret['error'] = 'noblock';
			return $ret;
		}
		$ret['text'] = $block -> getValue();
		$ret['bucketid'] = $bucketid;
		$ret['blockid'] = $blockid;
		
		if($bucket->canLiveEdit())
		{
			$ret['liveurl'] = $bucket->getLiveUrl();
		}
		
		return $ret;
	}
	
	protected function handlePost()
	{
		if(!empty($this->post['block_content']) && !empty($this->post['block']) && !empty($this->post['bucket']))
		{
			
			$blockid = $this->post['block'];
			$bucketid = $this->post['bucket'];
			$site = FrameworkController::loadsite();
			$bucket = $site -> getBucket($bucketid);
			$block = $bucket -> getBlock($blockid);
			$block -> setValue($this->post['block_content']);
			$text = $block -> getValue();
			$ret['postSuccess'] = true;
			return $ret;
		} else {
			$ret['postSuccess'] = false;
			return $ret;
		}
	}
	
	protected function handleAjax()
	{
		
	}
	
}

// //A handler for ajax requests to the code behind script
// if(isset($_GET['a'])){
	// if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['a']=='1')
	// {
		// $cbs = new EditCBS();
		// echo $cbs->handleAjax($_POST);
	// }
// }
