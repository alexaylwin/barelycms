<?php

/**
 	BlogBucket is a bucket type that allows for users to
 	create, manage and display entries that are sorted
	chorologically, and have common container HTML.
	
	The most signifcant feature of the BlogBucket from a
	framework perspective is that it implements Render().
	A bucket that has renderable attributes breaks the 
	original design principle, which required buckets to only
	be logical containers for blocks.
	
	This bucket renders the required child blocks in order
	by date, placing the content of each entry inside of
	it's container HTML.
**/
class BlogBucket extends Bucket implements Renderable, Feed
{
	//The sort order of the entries, defines how
	//the entries will be output
	public $sortOrder;
	
	//This is the header HTML for an entry
	public $entryTemplate;
		
	public $elementsPerPage;
		
	//initialize a new block, and add it to the bucket
	public function createBlock($entryDate, $author, $subject, $blockid)
	{
		$new_block = new EntryBlock($entryDate, $author, $subject, $blockid);
		$this->addBlock($new_block);
	}
	
	//Apply the configuration array to this object's instance variables, as required
	protected function applyConfig()
	{
		if(isset($this->config['sortOrder']))
		{
			$this->sortOrder = $this->config['sortOrder'];
		}
		
		if(isset($this->config['entryTemplate']))
		{
			$this->entryTemplate = $this->config['entryTemplate'];
		}

	}
	
	//Return a list of properties that should be serialized in the configuration array
	protected function getConfigProperties()
	{
		return array(
			"entryTemplate",
			"sortOrder"
		);
	}
	
	//Generate the HTML for this blog, parsing the entryTemplate
	public function render($renderProperties)
	{
		$renderBlocks = $this->getPage(0);
		$output = '';
		foreach($renderBlocks as $block)
		{
			$output = $output . '<br /> block:' . $block->render();
		}
		return $output;
	}
	
	public function getElementSortOrder()
	{
		return $this->sortOrder;
	}
	
	//In a blog, we only allow ordering by date
	public function setElementSortOrder($attribte, $direction)
	{
		return;
//		$this->sortOrder['attribute'] = $attribute;
//		$this->sortOrder['direction'] = $direction;
//		orderElements($this->sortOrder);
	}
		
	public function setElementsPerPage($count)
	{
		$this->elementsPerPage = $count;
	}
	
	public function getPage($pageNumber = 0)
	{
		//Return the blocks from page*elementsPerPage -> page+1*ElementsPerPage
		return $this->getElements($pageNumber * $this->elementsPerPage, ($pageNumber+1)*$this->elementsPerPage);
	}
	
	public function getElements($start = 0, $end = -1)
	{
		$list = $this->getAllBlocks();
		return ($end > 0) ? array_slice($list, $start, $end-$start) : array_slice($list, $start);
	}
	
	
	private function orderElements($sortOrder)
	{
		//Implement a bubble sort?
		$list = $this->getAllBlocks();
		foreach($list as $block)
		{
			$datelist[$block->getBlockId()] = $block->getEntryDate();
		}
		//TODO: simply this to just sort the block list directly - change cmpDates
		uasort($datelist, cmpDates);
		foreach($datelist as $id => $date)
		{
			$sortedList[] = $this->getBlock($id);
		}
		
		$this->blocklist = $sortedList;		
	}
	
	private function cmpDates($dateX, $dateY)
	{
		//TODO: Test this method, uses date format
//		$format = 'd/m/Y';
//		$ascending = ($this->sortOrder == 'asc');
//		$zone = new DateTimeZone('UTC');
//		$d1 = DateTime::createFromFormat($format, $dateX[1], $zone)->getTimeStamp();
//		$d2 = DateTime::createFromFormat($format, $dateY[1], $zone)->getTimeStamp();
//		return $ascending ? ($d1-$d2) : ($d2-$d1);
		if($dateX == $dateY) return 0;
		return (strtotime($dateX) < strtotime($dateY)) ? -1 : 1;
	}
}


?>