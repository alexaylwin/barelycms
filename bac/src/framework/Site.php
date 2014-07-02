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
				
		foreach($buckets as $bucketid)
		{	
			$bucketFactory = new BucketFactory();
			$new_bucket = $bucketFactory->load($bucketid);
			if($new_bucket)
			{
				$this->bucketlist[$bucketid] = $new_bucket;
			}
		}
	}
	
	/**
	 * Adds a new bucket with name pageid. This checks first to see if the bucket
	 * exists. If not, it creates the directory and adds the bucket to this site.
	 * 
	 * TODO: Change the implementation of this, to require a bucket type as well. 
	 */
	public function addBucket($bucketid, $buckettype = BucketTypes::Text)
	{
		if(!isset($this->bucketlist[$bucketid]))
		{
			$config['bucketid'] = $bucketid;
			$config['type'] = $buckettype;
			$bucketFactory = new BucketFactory();
			$new_bucket = $bucketFactory->build($config);
			$this->bucketlist[$bucketid] = $new_bucket;
			return true;			
			
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
