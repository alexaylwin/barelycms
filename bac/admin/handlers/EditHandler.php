<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class EditHandler extends RequestHandler
{
	
	protected function handleGet()
	{
		if(empty($this->get['container']) || empty($this->get['page']))
		{
			$ret['error'] = 'nocontainer';
			return $ret;
		}
		
		$containerid = $this->get['container'];
		$pageid = $this->get['page'];
		
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
	
	protected function handlePost()
	{
		if(!empty($this->post['container_content']) && !empty($this->post['container']) && !empty($this->post['page']))
		{
			
			$containerid = $this->post['container'];
			$pageid = $this->post['page'];
			$site = FrameworkController::loadsite();
			$page = $site -> getPage($pageid);
			$container = $page -> getContainer($containerid);
			$container -> setValue($this->post['container_content']);
			$text = $container -> getValue();
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

//A handler for ajax requests to the code behind script
if(isset($_GET['a'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['a']=='1')
	{
		$cbs = new EditCBS();
		echo $cbs->handleAjax($_POST);
	}
}
