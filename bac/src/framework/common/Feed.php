<?php

/**
	A feed is an interface that describes a contract for
	holding and displaying an ordered set of elements, which
	can be accessed by number or by 'page'. 
	
	The numbering of elements is dynamic, based on the current
	ordering attribute and direction. A bucket implementing this
	interface is responsible for ensuring that elements can be ordered
	correctly and returned correctly
**/
interface Feed
{
	/**
		Return an array with the sort attribute and direction
	**/
	public function getElementSortOrder();
	
	/**
		Set the sort order attribute and direction (asc or desc)
	**/
	public function setElementSortOrder($attribte, $direction);
	
	/**
		Return the elements, in the current sort order, between
		start and end
	**/
	public function getElements($start = 0, $end = -1);
	
	/**
		Set the number of elements that will be returned on a single
		page request
	**/
	public function setElementsPerPage($count);
	
	/**
		Get the elements that are on the page specified by pageId
	**/
	public function getPage($pageNumber = 0);
	
	/**
	
	qet a speciqfic element, based on the current sort order
	public getElement($elementNumber);
	 * 
	 */
}

?>