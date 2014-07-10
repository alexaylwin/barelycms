<?php

/**
 * BlockFactory is a creational class for building blocks. It's build()
 * method returns an object of Type block, by delegating the creation
 * to one of it's internal methods, which are specific to block types.
 */
class BlockFactory
{
	public function build($config)
	{
		if(!isset($config['type']) || !isset($config['blockid']))
		{
			return;
		}
		
		switch($config['type']){
			case BlockTypes::Text:
				return $this->buildTextBlock($config);
				break;
			case BlockTypes::Entry:
				return $this->buildEntryBlock($config);
				break;
			default:
				return;
				break;
		}
	}
	
	private function buildTextBlock($config)
	{
		$block = new TextBlock($config['blockid'], $config['bucketid']);
		return $block;
	}
	
	public function buildEntryBlock($config)
	{
		$entyDate = '';
		$author = '';
		$subject = '';
		$blockid = $config['blockid'];
		if(isset($config['entryDate']))
		{
			$entryDate = $config['entryDate'];
		}
		if(isset($config['author']))
		{
			$author = $config['author'];
		}
		if(isset($config['subject']))
		{
			$subject = $config['subject'];
		}
		$block = new EntryBlock($entryDate, $author, $subject, $blockid);
		return $block;
	}
	
	
	
}


?>