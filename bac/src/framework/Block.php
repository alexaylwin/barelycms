<?php
/**
 * /**
  * undocumented class
  *
  * @package default
  * @author  Alex Aylwin
 */
class Block
{
	private $value;
	private $blockid;
	private $filename;
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function getBlockId()
	{
		return $this->blockid;
	}
	
	/**
	 * This constructor accepts a bucket path and a container id.
	 * The bucket path should be the absolute file name of the script
	 * file that has a container on it.
	 */
	public function __construct($bucket_path, $block_id)
	{
		$io = new FileIO();
		
		//Build the file name from the bucket path (includes the bucket extension)
		//and the block id.
		$fullname = explode('.', $bucket_path);
		$bucketname = $fullname[0];
		$bucketname = strtolower($bucketname);
		$block_id = strtolower($block_id);
		//$filename = '../container_content/pages/' . $pagename . '/' . $container_id . '.incl';
		$filename = Constants::GET_PAGES_DIRECTORY() . '/' . $bucketname . '/' . $block_id . '.incl';
		$this->filename = $filename;
		
		$block_value = $io->readFile($filename);
		$this->value = $block_value;
		$this->blockid = $block_id;
	}
	
	public function setValue($new_value)
	{
		$this->value = $new_value;
		$io = new FileIO();
		$io->writeFile($this->filename, $new_value);
	}
		
}

?>