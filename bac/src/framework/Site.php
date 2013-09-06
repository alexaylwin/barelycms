<?php
class Site
{
	private $siteid;
	private $bucketlist = array();
	
	public function __construct($site)
	{
		$this->siteid = $site;
		$this->loadAllBuckets();
	}
	
	public function hasBucket($bucketid)
	{
		if(isset($this->bucketlist[$bucketid]))
		{
			return true;
		} else {
			return false;
		}
	}
	
	public function getSiteId()
	{
		return $this->siteid;
	}
	
	/**
	 * This returns the container with the given 
	 * cotnainer id or null if it doesn't exist
	 */
	public function getBucket($bucketid)
	{
		try
		{
			if(isset($this->bucketlist[$bucketid]))
			{
				return $this->bucketlist[$bucketid];
			} else {
				return;
			}
		} catch (Exception $e) {
			return;
		}
	}
	
	public function getAllBuckets()
	{
		
		return $this->bucketlist;
	}
	
	/**
	 * This loads all the pages containers into
	 * it's container array
	 */
	public function loadAllBuckets()
	{
		//$pages = scandir('../container_content/pages');
		$buckets = scandir(Constants::GET_PAGES_DIRECTORY());
		$io = new FileIO();
	
		
		//These are the . and .. directories
		unset($buckets[0]);
		unset($buckets[1]);
		//print_r($pages);
				
		foreach($buckets as $bucketid)
		{
			$bucketconfig = $io->readFile(Constants::GET_PAGES_DIRECTORY() . '/' . $bucketid . '/.bacproperties');
			$new_bucket = new Bucket($bucketconfig);
			$this->bucketlist[$bucketid] = $new_bucket;
		}
	}
	
	/**
	 * Adds a new page with name pageid. This checks first to see if the page
	 * exists. If not, it creates the directory and adds the page to this site.
	 */
	public function addBucket($bucketid, $liveurl = '')
	{
		$io = new FileIO();
		if(!isset($this->bucketlist[$bucketid]))
		{
		
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $bucketid;
			if (!file_exists($path)) {
				//It doesn't exist, so create the directory
				$res = mkdir($path);
				if (!$res) 
				{
					//error while trying to make the directory
					return false;
				} else {
					$config = "id:" . rawurlencode($bucketid) . "|liveurl:" . rawurlencode($liveurl);
					if(!file_exists($path . "/.bacproperties"))
					{
						$io->writeFile($path . "/.bacproperties", $config);
					}
					$new_bucket= new Bucket($config);
					$this->bucketlist[$bucketid] = $new_bucket;
					return true;
				}
			} elseif (file_exists($path) && !is_dir($path)) {
				//error, path exists and is not a directory
				return false;
			}
			
		} else {
			return false;
		}
	}
	
	/**
	 * Deletes the page from this site as well as the directory and any
	 * containers below it.
	 */
	public function removeBucket($bucketid)
	{
		if(isset($this->bucketlist[$bucketid]))
		{
			$path = Constants::GET_PAGES_DIRECTORY() . "/" . $bucketid;
			$io = new FileIO();
			if(!$io->deleteDirectory($path, true))
			{
				return false;
			}
			unset($this->bucketlist[$bucketid]);
			return true;
		} else {
			return false;
		}
	}
}
?>
