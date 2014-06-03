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
	public function build($configString)
	{
		$type = $this->getBucketType($configString);
		if($type == NULL){
			return;
		}
		
		switch ($type){
			case "Text":
				return $this->buildTextBucket($configString);
				break;
			default:
				break;
		}
		
	}
	
	//TODO: this is copied from Bucket->parseConfig
	private function getBucketType($configString)
	{
		$entries = explode("|", $configString);
		for($i = 0; $i < sizeof($entries); $i++)
		{
			$entry = $entries[$i];
			$kvp = explode(":", $entry);
			if(!empty($kvp[0]))
			{
				$config[$kvp[0]] = rawurldecode($kvp[1]);
			}			
		}
		
		if(isset($config['type']))
		{
			return $config['type'];
		} else {
			return null;
		}
	}
	
	private function buildTextBucket($configString)
	{
		return new TextBucket($configString);
	}
}


?>