<?php
session_start();
include_once ('../src/util.php');
require_once __DIR__. '/../src/framework/classloader.php';

/*
 * this is the login form, it provides a secure way to access the application. it relies on the
 * cred.php file, which holds a hashed version of the password.
 */
$message = '';
if (!isset($_SESSION['UID'])) {
	//If the form is submitted, then check the username and password
	if($_SERVER['REQUEST_METHOD'] === 'POST')
	{	
		if (isset($_POST['loginp']) && isset($_POST['loginu'])) {
			$u = $_POST['loginu'];
			$p = $_POST['loginp'];
			$p = sha1($p);
			//Unserialize all our users to check for a user with this name
			$io = new FileIO();
			$users = array();
			$userFiles = $io->getDirectoryFiles(Constants::GET_USERS_DIRECTORY());
			$cuser = new User('dummy1', 'dummy2');
			$userFound = false;
			foreach($userFiles as $userFile)
			{
				$val = $io->readFile(Constants::GET_USERS_DIRECTORY() . '/' . $userFile);
				$cuser = unserialize($val);
				if($cuser->getUsername() == $u)
				{
					$userFound = true;
					break;
				}
			}
			if($userFound)
			{
				if($cuser->getPassword() == $p)
				{
					session_start();
					$_SESSION['UID'] = $cuser->getUsername();
					$_SESSION['USER'] = $cuser;
					header("Location: " . get_absolute_uri('index.php'));
					
				} else {
					$message = "Please try again";
				}
			} else {
				$message = "Please try again";
			}
			
			
			// if(file_exists('../admin/config/cred.php'))
			// {
				// include_once ('../admin/config/cred.php');
	// 
				// //this would be some hash function
				// if ($p == $password && $u == $username) {
					// session_start();
					// $_SESSION['UID'] = $_POST['loginu'];
					// header("Location: " . get_absolute_uri('index.php'));
				// } else {
					// $message = "Please try again";
				// }
			// } else {
				// $message = "Please try again";
			// }
	
		} else {
			$message = "Please try again";
		}
	}
} else {
	//they're logged in, why are they back at the login page?
	//get back to home!
	header("Location: " . get_absolute_uri('index.php'));
	return;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="styles/styles.css" rel="stylesheet" media="screen" />
		<style type="text/css">
			.center {
				float: none;
				margin: 0 auto;
				text-align: center;
			}
			.control-group
			{
				margin-left:-160px;
			}
		</style>
</head>	
<body>
	<div class="container-fluid">
 		<div class="row" style="text-align:center;width:100%; margin:0; padding:0;">
            <div class="span12" style="display:inline-block; width:100%; margin:0; padding:0;">
				<div style="display: inline-block">
					<img src="images/logo-200.gif" style="width:75px; height:75px;"/>
					<form action="login.php" method="post" id="loginform" class="form-horizontal" style="text-align:center">
						<div class="control-group">
							<div class="controls">
								<span style="color:red;"><?php echo $message; ?></span><br />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for"loginu">Username:</label>
							<div class="controls">
								<input type="text" value="" name="loginu" id="loginu"/> <br />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for"loginp">Password:</label>
							<div class="controls">
								<input type="password" name="loginp" id="loginp"/> <br />
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-custom" id="login" type="submit">Login</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>	