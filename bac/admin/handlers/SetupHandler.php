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
		if($this->auth_exists())
		{
			$ret['notfirst'] = 'true';
		} else {
			$ret['notfirst'] = 'false';
		}
		return $ret;
	}
	
	private function auth_exists()
	{
		$path = Constants::GET_CONFIG_DIRECTORY() . '/cred.php';
		if (file_exists($path)) {
			return true; 
		} else {
			return false;
		}
		
	}
	
	protected function handlePost()
	{
		/**
		 * This section updates the administration password to the user supplied value
		 */
		$ret['message'] = 'Settings saved';
		$ret['settingsSaved'] = 'true';
		$passwordDefined = true;
		
		if($this->auth_exists())
		{
			$firstTime = false;
			$ret['redirectToLogin'] = 'false';
		} else {
			$firstTime = true;
			$ret['redirectToLogin'] = 'true';
		}
		if (isset($this->post['password']) && !empty($this->post['password'])) {
			if (isset($this->post['passwordConfirm']) && ($this->post['password'] == $this->post['passwordConfirm'])) {
				$newpass = sha1($this->post['password']);
				$newuser = 'admin';
	
				//TODO: rewrite to use FileIO
				//change the password
				$path = Constants::GET_CONFIG_DIRECTORY() . '/cred.php';
				if ($this->auth_exists()) {
					include_once ($path);
	
					$filelength = filesize($path);
					$fhandler = fopen($path, 'r');
					$text = fread($fhandler, $filelength);
					$text = str_replace($password, $newpass, $text);
				} else {
				//If no auth exists previously we need to create a whole new file
				//this case creates a username and dummy password, which is immediately
				//replaced by the user's defined password.
				$text = <<<'EOM'
	<?php
	
		$username = 'admin';
		$password = '{$newpass}'; 
	?>
EOM;
//					$password = '82e8253d257652f1342651a9c17332f0bde60572';
//					$text = str_replace($password, $newpass, $text);
				}
				$fhandlew = fopen($path, 'w');
				$res = fwrite($fhandlew, $text);
				if (!$res) {
					$ret['message'] = "Settings could not be saved";
					$ret['settingsSaved'] = 'false';
					$ret['redirectToLogin'] = 'false';
					$passwordDefined = false;
				}
			} else {
				//return 'error, passwords don't match' message
					$ret['message'] = "Passwords do not match";
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
	-
					//make a path
					//TODO: this needs to use a block factory method
					$site->getBucket($bucketname)->addBlock(new TextBlock($bucketname, $blockname));
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
	
}
		
?>
	