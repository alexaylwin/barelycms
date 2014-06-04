<?php

/**
 * BucketFactory is a factory class for building bucket objects from a 
 * configuration string. This is intended to allow other classes to access
 * the generic Bucket methods, without being tied to a specific bucket
 * implementation. 
 * 
 * TODO: rethink this approach. Should this class be given more responsbility
 * for initalizing class properties, rather than delegating it to the bucket
 * constructor? We are getting the type property anyway.
 */
class BucketFactory
{
	public function build($config)
	{
		
		//We require at least a type be set
		if(!isset($config['type']) || !isset($config['bucketid'])){
			return '';	
		}
		$type = $config['type'];
		switch ($type){
			case "Text":
				return $this->buildTextBucket($config);
				break;
			default:
				break;
		}
	}
	
	public function load($bucketid)
	{
		$io = new FileIO();
		$bucketConfigString = $io->readFile(Constants::GET_PAGES_DIRECTORY() . '/' . $bucketid . '/.bucket');
		$config = unserialize($bucketConfigString);
		
		if(isset($config['type']))
		{
			$type = $config['type'];
			switch ($type){
				case "Text":
					return $this->buildTextBucket($config);
					break;
				default:
					break;
			}		
		}
	}

	private function buildTextBucket($config)
	{
		//Do the writing in here
		return new TextBucket($config);
	}
}


?>