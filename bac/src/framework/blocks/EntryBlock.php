<?php
class EntryBlock extends Block implements Renderable
{
	private $entryDate;
	private $author;
	private $subject;
	
	public function __construct($entryDate, $author, $subject, $blockid)
	{
		$this->setBlockType(BlockTypes::Entry);
		$this->setBlockId($blockid);
		$this->setEntryDate($entryDate);
		$this->setAuthor($author);
		$this->setSubject($subject);
	}
	
	//Compile the values into the right template
	public function getValue()
	{
		return $this->value;
	}
	
	public function setValue($new_value)
	{
		$this->value = $new_value;
	}
	
	public function render($renderProperties = '')
	{
		return $this->getValue();
	}
	
	public function getEntryDate()
	{
		return $this->entryDate;
	}
	
	public function setEntryDate($entryDate)
	{
		$this->entryDate = $entryDate;
	}
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function setAuthor($author)
	{
		$this->author = $author;
	}
	
	public function getSubject()
	{
		return $this->subject();
	}
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
}    
?>