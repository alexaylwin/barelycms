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
		if (isset($this->post['password'])) {
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
					$text = <<<'EOM'
	<?php
		//default is 'admin' and 'BarelyACMS7'
		$username = 'admin';
		$password = '82e8253d257652f1342651a9c17332f0bde60572'; 
	?>
EOM;
					$password = '82e8253d257652f1342651a9c17332f0bde60572';
					$text = str_replace($password, $newpass, $text);
				}
				$fhandlew = fopen($path, 'w');
				$res = fwrite($fhandlew, $text);
				if (!$res) {
					$ret['message'] = "Settings could not be saved";
					$ret['settingSaved'] = 'false';
				}
			} else {
				//return 'error, passwords don't match' message
					$ret['message'] = "Passwords do not match";
					$ret['settingSaved'] = 'false';
			}
		} else {
			//Error, user didn't define a password
			$ret['message'] = "A password must be specified";
			$ret['settingSaved'] = 'false';
			
		}
	
		/*
		 * This section creates the directories and files for the buckets
		 */
		if (isset($this->post['sitemap'])) {
	
			//Get the existing site for comparison
			$site = FrameworkController::loadsite();
			$bucketlist = $site -> getAllBuckets();
			$blockarray = array();
			$bucketarray = array();
			
			foreach ($bucketlist as $bucket) {
				if ($bucket -> hasBlocks()) {
					$blocklist = $bucket -> getAllBlocks();
					foreach ($blocklist as $block) {
						//We assume that every container will be deleted
						$blockarray[$bucket -> getBucketId()][$block -> getBlockId()] = false;
					}
				}
				$bucketarray[$bucket -> getBucketId()] = false;
			}
	
			//The string looks like:
			//page1:container1,container2,container3|page2:container1,container2,container3
			$sitemap_string = $this->post['sitemap'];
	
			$buckets = explode("|", $sitemap_string);
			$bucketsdir = Constants::GET_PAGES_DIRECTORY();
	
			for ($i = 0; $i < count($buckets); $i++) {
				if (strlen($buckets[$i]) <= 1) {
					continue;
				}
				//Get the pagename and container list
				$bucket = explode(":", $buckets[$i]);
				$bucketname = $bucket[0];
				$blocks = $bucket[1];
				$blocks = explode(",", $blocks);
	
				//If we have no page name, then there's nothing to
				//do here (no blank page names)
				if ($bucketname == null || $bucketname == "") {
					continue;
				}
	
				//If the directory exists, we don't want to overwrite it
				//This adds the page
				$bucketarray[$bucketname] = true;
				$site->addBucket($bucketname);
	
				//Set up some default container text
				$blocktext = "";
	
				for ($j = 0; $j < count($blocks); $j++) {
					$block = $blocks[$j];
	
					//If the container name is blank do nothing (no blank container names)
					if ($block == null || $block == "") {
						continue;
					}
					//Don't delete this container!
					if (isset($blockarray[$bucketname][$block])) {
						$blockarray[$bucketname][$block] = true;
					}
	-
					//make a path
					$site->getBucket($bucketname)->addBlock($block);
				}
			}
	
			//Now delete all the containers that are still in the array
			foreach ($blockarray as $bucketname => $blocklist) {
				foreach ($blocklist as $block => $exists) {
					$path = $bucket . "/" . $bucketname;
					if (!$exists) {
						$site->getBucket($bucketname)->removeBlock($block);
					}
				}
			}
	
			//Now delete all the pages
			foreach ($bucketarray as $bucketname => $exists) {
				$path = $bucketsdir . "/" . $bucketname;
				if (!$exists) {
					$deleted = $site->removeBucket($bucketname);
				}
			}
	
		} else {
			//No site map
		}
		//header("Location: setup.php?m=Settings saved");
		$ret['message'] = 'Settings saved';
		$ret['settingsSaved'] = 'true';
		return $ret;
	}
	
	protected function handleAjax()
	{
	}
	
	private function build_sitemap_string() {
		$sitemapstring = "";
	
		$site = FrameworkController::loadsite();
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
	
}
		
?>
	