<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class PagesHandler extends RequestHandler
{
	
	protected function handleGet()
	{
		$site = FrameworkController::loadsite();
		$pagelist = $site -> getAllPages();
		
		$maxcontainers = 0;
		foreach($pagelist as $page)
		{
			$containerlist = $page->getAllContainers();
			if(count($containerlist) > $maxcontainers)
			{
				$maxcontainers = count($containerlist);
			}
		}

		$ret['pagelist'] = $pagelist;
		$ret['maxcontainers'] = $maxcontainers;
		return $ret;
	}
	
	protected function handlePost()
	{
		
	}
	
	protected function handleAjax()
	{
		$data = false;
		if(isset($this->post['pageurl']) && isset($this->post['pageid']))
		{
			if(!empty($this->post['pageurl']))
			{
				$site = FrameworkController::loadsite();
				$page = $site->getPage($this->post['pageid']);
				$page->setLiveUrl($this->post['pageurl']);
				$data['success'] = $page->writeConfig();
				$data['liveUrl'] = $page->getLiveUrl();
				$data['pageId'] = $page->getPageId();
			}
		}
		$ret['ajax'] = true;
		$ret['data'] = $data;
		return $ret;
	}
}
?>