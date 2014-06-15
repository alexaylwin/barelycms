<?php
class EntryBlock extends Block implements Renderable
{
	private $entryDate;
	private $author;
	private $text;
	private $subject;
	
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
	
	public function getEntryDate()
	{
		return $this->entryDate;
	}
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function getSubject()
	{
		return $this->subject();
	}
}    
?>