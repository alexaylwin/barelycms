<?php
/**

**/

abstract class Bucket {
	
	private $bucketid;
	
	private $blocklist;
	
	/**
	 * The config object contains meta data about the bucket in KVPs as
	 * defined by the bucket type.
	 */
	private $config;
	
	private $type;
	
}


?>