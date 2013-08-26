<?php
/**
 * The request handler intercepts requests as they come
 * to admin pages. 
 */
abstract class RequestHandler
{
	var $post;
	var $get;

	abstract protected function handleGet();
	abstract protected function handlePost();
	abstract protected function handleAjax();
	
	public function handleRequest($post, $get)
	{
		$this->post = $post;
		$this->get = $get;
		if($_SERVER['REQUEST_METHOD'] === 'POST' && (!empty($post['a']) || !empty($get['a'])))
		{
			$data = $this->handleAjax();
		} else if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$dataPost = $this->handlePost();
			$dataGet = $this->handleGet();
			$data = array_merge($dataGet, $dataPost);
		} else {
			$data = $this->handleGet();
		}
		
		return $data;
	}

}

?>