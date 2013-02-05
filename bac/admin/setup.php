<?php
/**
 * This is the setup script for the first install. As of 1.0, it only has two
 * user configurable options - admin password and creating the sitemap. 
 * 
 * To set up the BAC installation, run this file. It will first ask for an
 * admin password, then ask the user to enter each page and container 
 * on that page that they want managed by BAC.
 * 
 * The mechanism for the sitemap is currently manual. Ideally, this will
 * be replaced by an automatic funciton that can do one of two things:
 * 1)	Scan the web root and look at each file, determining if the file
 * 		has BAC managed containers
 * 2)	Be able to securely and reliably identify Ajax calls from the 
 * 		installation domain, and automatically generate content files
 * 		at an ajax request, if the file does not exist.  
 */
 
 
 /*
 * We require the user to be logged in to perform setup. This means that 
 * the user must log in with the default password, then be logged out
 * and log back in with their secure password to access this script.
 * this ensures that only users with the admin password can actually
 * access this script.
 * */
include('auth.php');
 
 // not secure
 if(isset($_POST['submitted']))
 {
	/**
	 * This section updates the administration password to the user supplied value
	 
	if(isset($_POST['password']))
	{
		if(isset($_POST['passwordConfirm']) && ($_POST['password'] == $_POST['passwordConfirm']))
		{
			$newpass = sha1($_POST['password']);
			$newuser = 'admin';
			
			//change the password
			$path = '../admin/lock/cred.php';
			include_once($path);
			
			$filelength = filesize($path);
			$fhandler = fopen($path, 'r');
			$text = fread($fhandler, $filelength);
			$text = str_replace($password, $newpass, $text);
			
			$fhandlew = fopen($path, 'w');
			$res = fwrite($fhandlew, $text);
			if(!$res){
				header("Location: " .  get_absolute_uri('settings.php?m=Settings could not be saved'));
			}
		} else {
			//return 'error, passwords don't match' message
			header("Location: " .  get_absolute_uri('settings.php?m=Passwords do not match'));
		}
	} else {
		//Error, user didn't define a password
		header("Location: " . get_absolute_uri('settings.php?m=A password must be set'));
	}*/
	
	/*
	 * This section creates the directories and files for the content containers
	 */
	if(isset($_POST['sitemap']))
	{
		//The string looks like:
		//page1:container1,container2,container3|page2:container1,container2,container3
		$sitemap_string = $_POST['sitemap'];
		$pages = explode("|", $sitemap_string);
		
		$pagesdir = "../container_content/pages"; 
		
		for($i = 0; $i < count($pages); $i++) 
		{
			$page = explode(":", $pages[$i]);
			$pagename = $page[0];
			$containers = $page[1];
			$containers = explode(",", $containers);
			
			$path = $pagesdir . "/" . $pagename;
			if(!file_exists($path))
			{
				//error, file exists
				$res = mkdir($path);
				if(!$res)
				{
					//error 
					echo "error creating page";
				}
			} elseif (file_exists($path) && !is_dir($path)) {
				//error, path exists and is not a directory
			}

			$containertext = "Edit this container from the BAC Admin Panel!";
			for($j = 0; $j < count($containers); $j++)
			{
				$container = $containers[$j];
				$path = $pagesdir . "/" . $pagename . "/" . $container . ".incl";
				if(!file_exists($path))
				{
					$fhandlew = fopen($path, 'w');
					$res = fwrite($fhandlew, $containertext);
					if(!$res)
					{
						//error
						echo "error creating container";
					}
				} else {
					//file exists, don't overwrite
				}
			}	
		}
	} else {
		echo "No site map";
	}
	
 } 
 else
 {
	//show the form
echo <<<EOM
<html>
<head>

</head>
<body>
	<form method="post">
	<input name="sitemap" id="sitemap" />
	<input name="submitted" type="hidden" value="1" />
	<input type="submit"/>
</body>
</html>
EOM;
	
 }
 
?>

