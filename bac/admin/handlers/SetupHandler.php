<?php
require_once __DIR__. '/../../src/framework/classloader.php';

/**
 * Pages code behind file. This script is for the Page view. 
 */
class SetupHandler extends RequestHandler
{
	protected function handleGet()
	{
		//Check to see if this is the first run,
		//if cred exists, then we have run before
		$ret['sitemap'] = $this->build_sitemap_string();
		if($this->adminExists())
		{
			$ret['notfirst'] = 'true';
		} else {
			$ret['notfirst'] = 'false';
		}
		return $ret;
	}
		
	protected function handlePost()
	{
		/**
		 * This section updates the administration password to the user supplied value
		 */
		$ret['message'] = 'Settings saved';
		$ret['settingsSaved'] = 'true';
		$passwordDefined = true;
		
		if($this->adminExists())
		{
			$firstTime = false;
			$ret['redirectToLogin'] = 'false';
		} else {
			$firstTime = true;
			$ret['redirectToLogin'] = 'true';
		}
//HANDLE ADMIN ACCOUNT
		if (isset($this->post['adminPassword']) && !empty($this->post['adminPassword'])) {
			if (isset($this->post['adminPasswordConfirm']) && ($this->post['adminPassword'] == $this->post['adminPasswordConfirm'])) {
				$newpass = sha1($this->post['adminPassword']);
				$newuser = 'admin';
				$usertype = UserTypes::Admin;
				
				//Create default permissions
				$pagePermissions = array();
				$bucketsPermissions = new PagePermissions(array(PagePermissions::c_pagename => 'buckets', 
					PagePermissions::c_actionPermissions => array(
						'all' => ActionPermissions::Allowed
				)));
				$pagePermissions['buckets'] = $bucketsPermissions;
				
				$setupPermissions = new PagePermissions(array(PagePermissions::c_pagename => 'setup', 
					PagePermissions::c_actionPermissions => array(
						'all' => ActionPermissions::Allowed
				)));
				$pagePermissions['setup'] = $setupPermissions;

				//create new user
				$userCreated = $this->createUser($newuser, $newpass, $usertype, $pagePermissions);
				
				if (!$userCreated) {
					$ret['message'] = "Settings could not be saved";
					$ret['settingsSaved'] = 'false';
					$ret['redirectToLogin'] = 'false';
					$passwordDefined = false;
				}
			} else {
				//return 'error, passwords don't match' message
					$ret['message'] = "Admin passwords do not match";
					$ret['settingsSaved'] = 'false';
					$ret['redirectToLogin'] = 'false';
					$passwordDefined = false;
			}
		} else {
			//Error, user didn't define a password
			if($firstTime)
			{
				$ret['message'] = "A password must be specified";
				$ret['settingsSaved'] = 'false';
				$ret['redirectToLogin'] = 'false';
				$passwordDefined = false;
			}

		}
		
//HANDLE AUTHOR ACCOUNT
		if (isset($this->post['authorPassword']) && !empty($this->post['authorPassword'])) {
			if (isset($this->post['authorPasswordConfirm']) && ($this->post['authorPasswordConfirm'] == $this->post['authorPasswordConfirm'])) {
				$newpass = sha1($this->post['authorPassword']);
				$newuser = 'author';
				$usertype = UserTypes::Author;
				
				//Create default permissions
				$pagePermissions = array();
				$bucketsPermissions = new PagePermissions(array(PagePermissions::c_pagename => 'buckets', 
					PagePermissions::c_actionPermissions => array(
						'createBucket' => ActionPermissions::Denied,
						'deleteBucket' => ActionPermissions::Denied,
						'createBlock' => ActionPermissions::Denied,
						'deleteBlock' => ActionPermissions::Denied,
						'createBlogBlock' => ActionPermissions::Allowed,
						'deleteBlogBlock' => ActionPermissions::Allowed,
						'editBlock' => ActionPermissions::Allowed
					)));
				$pagePermissions['buckets'] = $bucketsPermissions;
				
				$setupPermissions = new PagePermissions(array(PagePermissions::c_pagename => 'setup', 
					PagePermissions::c_actionPermissions => array(
						'createBucket' => ActionPermissions::Denied,
						'deleteBucket' => ActionPermissions::Denied,
						'createBlock' => ActionPermissions::Denied,
						'deleteBlock' => ActionPermissions::Denied,
						'changeAdminPassword' => ActionPermissions::Denied,
						'changeAuthorPassword' => ActionPermissions::Allowed
					)));
				
				$pagePermissions['setup'] = $setupPermissions;
				
				//Create new user
				$userCreated = $this->createUser($newuser, $newpass, $usertype, $pagePermissions);
				
				if (!$userCreated) {
					$ret['message'] = "Settings could not be saved";
					$ret['settingsSaved'] = 'false';
					$ret['redirectToLogin'] = 'false';
					$passwordDefined = false;
				}
			} else {
				//return 'error, passwords don't match' message
					$ret['message'] = "Admin passwords do not match";
					$ret['settingsSaved'] = 'false';
					$ret['redirectToLogin'] = 'false';
					$passwordDefined = false;
			}
		}

		/*
		 * This section creates the directories and files for the buckets
		 */
		if (isset($this->post['sitemap']) && $passwordDefined) {
	
			//Get the existing site for comparison
			$framework = new FrameworkController();
			$site = $framework->getSite();
			$bucketlist = $site -> getAllBuckets();
			$blockarray = array();
			$bucketarray = array();
			
			//This loop marks every block and bucket for deletion
			foreach ($bucketlist as $bucket) {
				if ($bucket -> hasBlocks()) {
					$blocklist = $bucket -> getAllBlocks();
					foreach ($blocklist as $block) {
						$blockarray[$bucket -> getBucketId()][$block -> getBlockId()] = false;
					}
				}
				$bucketarray[$bucket -> getBucketId()] = false;
			}
	
			//The string looks like:
			//page1:container1,container2,container3|page2:container1,container2,container3
			$sitemap_string = $this->post['sitemap'];
	
		
			$bucketsArray = explode("|", $sitemap_string);
			$bucketsdir = Constants::GET_PAGES_DIRECTORY();

			for ($i = 0; $i < count($bucketsArray); $i++) {
				if (strlen($bucketsArray[$i]) <= 1) {
					continue;
				}
				//Get the bucket and block list from the bucket string
				$bucketstring = explode(":", $bucketsArray[$i]);
				$bucketname = $bucketstring[0];
				$blockstring = $bucketstring[1];
				$blockNameArray = explode(",", $blockstring);
	
				//If we have no bucket name, then there's nothing to
				//do here (no bucket page names)
				if ($bucketname == null || $bucketname == "") {
					continue;
				}
	
				//If the directory exists, we don't want to overwrite it
				//This adds the page
				$bucketarray[$bucketname] = true;
				$result = $site->addBucket($bucketname);
	
				$blocktext = "";
	
				for ($j = 0; $j < count($blockNameArray); $j++) {
					$blockname = $blockNameArray[$j];
	
					//If the block name is blank do nothing (no blank bucket names)
					if ($blockname == null || $blockname == "") {
						continue;
					}
					//Don't delete this block!
					if (isset($blockarray[$bucketname][$blockname])) {
						$blockarray[$bucketname][$blockname] = true;
					}
	
					//TODO: this needs to be refactored, we aren't creating a new block every time, only loading
					//blocks that exist.
					$bucket = $site->getBucket($bucketname);
					if(!$bucket->hasBlock($blockname))
					{
						$newblockConfig = Array(
							"type" => BlockTypes::Text,
							"blockid" => $blockname,
							"bucketid" =>$bucketname
						);
						$factory = new BlockFactory();
						$newblock = $factory->build($newblockConfig);
						$bucket->addBlock($newblock);
					}
					
				}
			}
	
			//Now delete all the blocks that are still in the array as false
			foreach ($blockarray as $bucketname => $blocklist) {
				foreach ($blocklist as $blockname => $exists) {
					if (!$exists) {
						$currentbucket = $site->getBucket($bucketname);
						$result = $currentbucket->removeBlock($blockname);
					}
				}
			}
	
			//Now delete the bucket
			foreach ($bucketarray as $bucketname => $exists) {
				$path = $bucketsdir . "/" . $bucketname;
				if (!$exists) {
					$deleted = $site->removeBucket($bucketname);
				}
			}
	
		} else {
			//No site map
		}
		return $ret;
	}
	
	protected function handleAjax()
	{
	}
	
	private function build_sitemap_string() {
		$sitemapstring = "";
	
		$framework = new FrameworkController();
		$site = $framework->getSite();
		if (!$site)
			return;
	
		$bucketlist = $site -> getAllBuckets();
		if (!$bucketlist)
			return;
	
		$maxblocks = 0;
		$firstbucket = true;
		foreach ($bucketlist as $bucket) {
			if ($firstbucket) {
				$sitemapstring = $sitemapstring . $bucket -> getBucketId() . ":";
			} else {
				$sitemapstring = $sitemapstring . '|' . $bucket -> getBucketId() . ":";
			}
	
			$firstbucket = false;
			$firstblock = true;
	
			$blocklist = $bucket -> getAllBlocks();
			if ($blocklist) {
				foreach ($blocklist as $block) {
					if ($firstblock) {
						$sitemapstring = $sitemapstring . $block -> getBlockId();
					} else {
						$sitemapstring = $sitemapstring . ',' . $block -> getBlockId();
					}
					$firstblock = false;
	
				}
			}
		}
	
		return $sitemapstring;
	}
	
	/**
	 * This function parses a sitemap string into an array of bucket and block ids
	 */
	private function parse_sitemap_string($sitemap)
	{
		
	}
	
	private function adminExists()
	{
		$io = new FileIO();
		$path = Constants::GET_USERS_DIRECTORY() . '/' . 'admin.usr';
		if ($io->fileExists($path)) {
			return true; 
		} else {
			return false;
		}
		
	}
	
	private function createUser($username, $password, $usertype, $pagePermissions)
	{
		$io = new FileIO();
		$newuser = new User($username, $usertype);
		$newuser->setPassword($password);
		if(!empty($pagePermissions)) 
		{
			foreach($pagePermissions as $page => $perm)
			{
				$newuser->addPagePermission($page, $perm);
			}
		}
		$filename = Constants::GET_USERS_DIRECTORY() . '/' . $username . '.usr';
		$serialized = serialize($newuser);
		
		return $io->writeFile($filename, $serialized);
		
	}
	
}
		
?>
	