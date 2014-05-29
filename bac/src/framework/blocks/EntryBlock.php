<?php
class EntryBlock extends Block implements Renderable
{
	private $entryDate;
	private $author;
	private $text;
	
	//Compile the values into the right template
	public function getValue()
	{
		
	}
	
	public function setValue($new_value)
	{
		
	}
	
	public function render($renderProperties)
	{
		return $this->getValue();
	}
}    
?>