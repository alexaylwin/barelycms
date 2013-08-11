<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class PagesCBS extends CodeBehindScript
{
	function handleView()
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

		$data['pagelist'] = $pagelist;
		$data['maxcontainers'] = $maxcontainers;
		return $data;
	}
	
	function handlePost($data)
	{
		
	}
	
	function handleAjax($data)
	{
		$ret = false;
		if(isset($data['pageurl']) && isset($data['pageid']))
		{
			if(!empty($data['pageurl']))
			{
				$site = FrameworkController::loadsite();
				$page = $site->getPage($data['pageid']);
				$page->setLiveUrl($data['pageurl']);
				$ret = $page->writeConfig();
			}
		}
		return $ret;
	}
}

//A handler for ajax requests to the code behind script
if(isset($_GET['a'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['a']=='1')
	{
		$cbs = new PagesCBS();
		echo $cbs->handleAjax($_POST);
	}
}

?>