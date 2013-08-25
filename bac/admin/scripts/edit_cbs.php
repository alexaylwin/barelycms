<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class EditCBS extends CodeBehindScript
{
	
	function handleView($data)
	{
		if(empty($data['container']) || empty($data['page']))
		{
			$ret['error'] = 'nocontainer';
			return $ret;
		}
		
		$containerid = $data['container'];
		$pageid = $data['page'];
		
		$site = FrameworkController::loadsite();
		$page = $site -> getPage($pageid);
		$container = $page -> getContainer($containerid);
		
		$ret['text'] = $container -> getValue();
		$ret['pageid'] = $pageid;
		$ret['containerid'] = $containerid;
		
		if($page->canLiveEdit())
		{
			$ret['liveurl'] = $page->getLiveUrl();
		}
		
		return $ret;
	}
	
	function handlePost($data)
	{
		if(!empty($data['container_content']) && !empty($data['container']) && !empty($data['page']))
		{
			
			$containerid = $data['container'];
			$pageid = $data['page'];
			$site = FrameworkController::loadsite();
			$page = $site -> getPage($pageid);
			$container = $page -> getContainer($containerid);
			$container -> setValue($data['container_content']);
			$text = $container -> getValue();
			return 1;
		} else {
			return 0;
		}
	}
	
	function handleAjax($data)
	{
		
	}
	
}

//A handler for ajax requests to the code behind script
if(isset($_GET['a'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['a']=='1')
	{
		$cbs = new EditCBS();
		echo $cbs->handleAjax($_POST);
	}
}
