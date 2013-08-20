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
 * this ensures that only users with the adm
 * in password can actually
 * access this script.
 * */

include '../src/framework/classloader.php';

//This could be moved into the framework as a site->toString(mode) method
function build_sitemap_string() {
	$sitemapstring = "";

	$site = FrameworkController::loadsite();
	if (!$site)
		return;

	$pagelist = $site -> getAllPages();
	if (!$pagelist)
		return;

	$maxcontainers = 0;
	$firstpage = true;
	foreach ($pagelist as $page) {
		if ($firstpage) {
			$sitemapstring = $sitemapstring . $page -> getPageId() . ":";
		} else {
			$sitemapstring = $sitemapstring . '|' . $page -> getPageId() . ":";
		}

		$firstpage = false;
		$firstcontainer = true;

		$containerlist = $page -> getAllContainers();
		if ($containerlist) {
			foreach ($containerlist as $container) {
				if ($firstcontainer) {
					$sitemapstring = $sitemapstring . $container -> getContainerId();
				} else {
					$sitemapstring = $sitemapstring . ',' . $container -> getContainerId();
				}
				$firstcontainer = false;

			}
		}
	}

	return $sitemapstring;
}

//Check to see if this is the first run,
//if cred exists, then we have run before
$path = '../admin/config/cred.php';
if (file_exists($path)) {
	$notfirst = true;
	include ('auth.php');
} else {
	$notfirst = false;
}
// not secure
if (isset($_POST['submitted'])) {
	/**
	 * This section updates the administration password to the user supplied value
	 */
	if (isset($_POST['password'])) {
		if (isset($_POST['passwordConfirm']) && ($_POST['password'] == $_POST['passwordConfirm'])) {
			$newpass = sha1($_POST['password']);
			$newuser = 'admin';

			//change the password
			$path = '../admin/config/cred.php';
			if ($notfirst) {
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
				header("Location: " . get_absolute_uri('setup.php?m=Settings could not be saved'));
			}
		} else {
			//return 'error, passwords don't match' message
			header("Location: " . get_absolute_uri('setup.php?m=Passwords do not match'));
		}
	} else {
		//Error, user didn't define a password
		header("Location: " . get_absolute_uri('setup.php?m=A password must be set'));
	}

	/*
	 * This section creates the directories and files for the content containers
	 */
	if (isset($_POST['sitemap'])) {

		//Get the existing site for comparison
		$site = FrameworkController::loadsite();
		$pagelist = $site -> getAllPages();
		$containerarray = array();
		$pagearray = array();
		
		foreach ($pagelist as $page) {
			if ($page -> hasContainers()) {
				$containerlist = $page -> getAllContainers();
				foreach ($containerlist as $container) {
					//We assume that every container will be deleted
					$containerarray[$page -> getPageId()][$container -> getContainerId()] = false;
				}
			}
			$pagearray[$page -> getPageId()] = false;
		}

		//The string looks like:
		//page1:container1,container2,container3|page2:container1,container2,container3
		$sitemap_string = $_POST['sitemap'];

		$pages = explode("|", $sitemap_string);
		$pagesdir = "../container_content/pages";

		for ($i = 0; $i < count($pages); $i++) {
			if (strlen($pages[$i]) <= 1) {
				continue;
			}
			//Get the pagename and container list
			$page = explode(":", $pages[$i]);
			$pagename = $page[0];
			$containers = $page[1];
			$containers = explode(",", $containers);

			//If we have no page name, then there's nothing to
			//do here (no blank page names)
			if ($pagename == null || $pagename == "") {
				continue;
			}

			//If the directory exists, we don't want to overwrite it
			//This adds the page
			$pagearray[$pagename] = true;
			$site->addPage($pagename);

			//Set up some default container text
			$containertext = "";

			for ($j = 0; $j < count($containers); $j++) {
				$container = $containers[$j];

				//If the container name is blank do nothing (no blank container names)
				if ($container == null || $container == "") {
					continue;
				}
				//Don't delete this container!
				if (isset($containerarray[$pagename][$container])) {
					$containerarray[$pagename][$container] = true;
				}

				//make a path
				$site->getPage($pagename)->addContainer($container);
			}
		}

		//Now delete all the containers that are still in the array
		foreach ($containerarray as $pagename => $containerlist) {
			foreach ($containerlist as $container => $exists) {
				$path = $page . "/" . $pagename;
				if (!$exists) {
					$site->getPage($pagename)->removeContainer($container);
				}
			}
		}

		//Now delete all the pages
		foreach ($pagearray as $pagename => $exists) {
			
			$path = $pagesdir . "/" . $pagename;
			if (!$exists) {
				$site->removePage($pagename);
			}
		}

	} else {
		//No site map
	}
	header("Location: setup.php?m=Settings saved");
}
?>
<?php
if(isset($_GET['m']))
{
	$message = $_GET['m'];
	$displaymessage = "block";
} else {
	$message = "";
	$displaymessage = "none";
}

if($notfirst)
{
	include 'header.php';
} else {
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="styles/styles.css" rel="stylesheet" media="screen" />
</head>	
<body>
	<div class="container-fluid">
	   	<div class="navbar navbar-fixed-top navbar-inverse" id="header">
 			<div class="navbar-inner" id="menubar">
    			<a class="brand" href="#" id="titlebar">BAC</a>

   				<div id="logout" class="pull-right">
					<a href=""><i class="icon-off invisible"></i> Domain <br /></a>
					<a href="logout.php"><i class="icon-off icon-white"></i> Logout</a>
   			</div>
   			</div>
    	</div>
		<div class="row-fluid">
			<div class="span10 offset1">
				<div id="content">					
<?php
}
?>

	<script type="text/javascript" src="js/setupform.js"></script>	
					<?php
					if(!$notfirst)
					{
					?>
					<p>
						<h3>Welcome to BarelyACMS!</h3>
							BAC is a new way of thinking about content management systems.
						BAC believes in doing only one thing, <strong>managing content</strong>. <br /> <br />
						
						It doesn't help you create themes, layouts or even new pages. It won't do CSS for you, 
						it won't provide plugins to help you set up an email list or twitter feed. <br /> <br />
						
						What it will do, is <strong>promise to not get in the way</strong>. It isn't designed to be
						a website building solution, but simply a way for users to manage the content on their website.
						BAC lets you, the web designer, focus on design your website hassle free and create the
						content later.						
					</p>
					<br />
					<?php
					}
					?>
					<p>
						<h4>Setup</h4>
						<div class="alert alert-success" style="display:<?php echo $displaymessage; ?>;
"><?php echo $message; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
						To set up BAC, set up an administrative password and then define your sitemap.
					</p>
					
					<form method="post" class="form-horizontal" id="setupform">
						<h6>Admin Password</h6>
						<p>
							Define the administrative password that you'll use to
							access the BAC admin panel.
						</p>
						<div class="control-group">
							<label class="control-label" for"username">Username</label>
							<div class="controls">
								<p style="display:inline-block; margin-bottom:0; margin-top: 1px;vertical-align:middle;font-size:14px;height:20px;line-height:20px;padding:4px 6px;"><strong>admin</strong></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password">Password</label>
							<div class="controls">
								<input type="password" name="password" id="password">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="passwordConfirm">Confirm password</label>
							<div class="controls">
								<input type="password" name="passwordConfirm" id="passwordConfirm">
							</div>
						</div>
						<h6>Sitemap</h6>
						<p>
							BAC works by letting you include content containers dynamically within a page. This
							section lets you pre-define the pages and containers that will exist within your
							website. You can modify this later, but it is recommended that you set up a skeleton
							framework of the site (even if its just an index page!).
						</p>
						<ul id="controllist" class="unstyled"></ul>
						<input name="sitemap" id="sitemap" type="hidden" value="<?php echo build_sitemap_string(); ?>"
/>
<input name="submitted" type="hidden" value="1" />
<br />

<?php
if($notfirst)
{
?>
<button class="btn btn-custom" id="save" type="submit">
Save Configuration
</button>
<?php
}
else
{
?>

<button class="btn btn-custom" id="save" type="button" onclick="javascript:$('#savemodal').modal();">
Save Configuration
</button>
</form>
<div id="savemodal" class="modal hide fade">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;
</button>
<h3>You're done!</h3>
</div>
<div class="modal-body">
<p>
That's it! When you click 'Continue', you will be taken to the BAC Administrative Panel login page, where you will be asked to log in with the following credentials: <br />
Username: admin <br />
Password: <i>User defined</i>
<br /> <br />
To change any of these settings, log into the admin panel and go to Setup
</p>
</div>
<div class="modal-footer">
<a href="#" class="btn" id="cancel" data-dismiss="modal" aria-hidden="true">Cancel</a>
<a href="#" class="btn btn-primary" id="continue">Continue</a>
</div>
</div>

<?php
}
?>
<?php
include 'footer.php';
?>

