<?php
	//Load Interfaces
	//TODO: replace with __autoload();
	include_once 'common/Renderable.php';
	include_once 'common/Feed.php';
	
	//Load object factories
	include_once 'buckets/BucketFactory.php';

	//Load block types
	include_once 'common/BlockTypes.php';
    include_once 'blocks/Block.php';
	include_once 'blocks/TextBlock.php';
	
	//Load bucket types
	//include_once 'Bucket.php';
	include_once 'common/BucketTypes.php';
	include_once 'buckets/Bucket.php';
	include_once 'buckets/TextBucket.php';
	include_once 'buckets/BlogBucket.php';
	
	//Load framework classes
	include_once 'FrameworkController.php';
	include_once 'Site.php';
	include_once 'FileIO.php';
	include_once 'RequestHandler.php';
	
	//Load utility functions
	include_once 'Constants.php';
?>