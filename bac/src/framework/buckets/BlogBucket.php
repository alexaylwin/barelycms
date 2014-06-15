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
	protected $sortOrder
	
	//This is the header HTML for an entry
	protected $entryTemplate;
		
	protected $elementsPerPage;
		
	//initialize a new block, and add it to the bucket
	public function createBlock($blockid)
	{
		
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
			$this->entryHeader = $this->config['entryTemplate'];
		}

	}
	
	//Return a list of properties that should be serialized in the configuration array
	protected function getConfigProperties()
	{
		return array(
			"entryTemplate",
			"sortOrder"
		)	
	}
	
	//Generate the HTML for this blog
	public render()
	{
		$renderBlocks = $this->getPage(0);
		$output = '';
		for($renderBlocks as $block)
		{
			
		}
	}
	
	public getElementSortOrder()
	{
		return $this->sortOrder;
	}
	
	//In a blog, we only allow ordering by date
	public setElementSortOrder($attribte, $direction)
	{
		return;
//		$this->sortOrder['attribute'] = $attribute;
//		$this->sortOrder['direction'] = $direction;
//		orderElements($this->sortOrder);
	}
	
	public getElements($start = 0, $end = -1)
	{
		$list = $this->getAllBlocks();
		return ($end > 0) ? array_slice($list, $start, $end-$start) : array_slice($list, $start);
	}
	
	public setElementsPerPage($count)
	{
		$this->elementsPerPage = $count;
	}
	
	public getPage($pageNumber = 0)
	{
		//Return the blocks from page*elementsPerPage -> page+1*ElementsPerPage
		return getElements($pageNumber * $this->elementsPerPage, ($pageNumber+1)*$this->elementsPerPage);
	}
	
	private orderElements($sortOrder)
	{
		//Implement a bubble sort?
		$list = $this->getAllBlocks();
		for($list as $block)
		{
			$datelist[$block->getBlockId()] = $block->getEntryDate();
		}
		//TODO: simply this to just sort the block list directly - change cmpDates
		uasort($datelist, cmpDates);
		for($datelist as $id => $date)
		{
			$sortedList[] = $this->getBlock($id);
		}
		
		$this->blocklist = $sortedList;		
	}
	
	function cmpDates($dateX, $dateY)
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