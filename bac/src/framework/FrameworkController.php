<?php
class FrameworkController
{
	private $site = '';
	
	public function __construct()
	{
		$this->site = $this->loadsite();
	}
	
	private function loadsite()
	{
		//For now, only support one site
		$site = new Site('default');
		return $site;

	}
	
	private function renderElement($element)
	{
		return $element->render(null);
	}
	
	public function getContent($elementCollection)
	{
		$markup = '';
		foreach($elementCollection as $key => $value)
		{
			if($this->site->hasBucket($key))
			{
				$bucket = $this->site->getBucket($key);
				if($bucket->hasBlock($value))
				{
					$block = $bucket->getBlock($value);
					$markup = $markup . $this->renderElement($block);
				}
			}
		}
		return $markup;
	}
	
}
?>