<?php
session_start();
include_once ('../src/util.php');

/*
 * this is the login form, it provides a secure way to access the application. it relies on the
 * lock.z file, which holds a hashed version of the password.
 */
if (!isset($_SESSION['UID'])) {
	//If the form is submitted, then check the username and password
	if (isset($_POST['loginp']) && isset($_POST['loginu'])) {
		//$file = fopen('../admin/lock/lock.z', 'r');
		//$hashpwd = fread($file, filesize('../admin/lock/lock.z'));
		$u = $_POST['loginu'];
		$p = $_POST['loginp'];
		$p = sha1($p);
		include_once ('../admin/lock/cred.php');

		//this would be some hash function
		if ($p == $password && $u == $username) {
			session_start();
			$_SESSION['UID'] = $_POST['loginu'];
			header("Location: " . get_absolute_uri('index.php'));
		} else {
			header("Location: " . get_absolute_uri('login.php?m=Bad Password'));
			die();
		}

	}
	$message = '';
	if (isset($_GET['m'])) {
		$message = htmlspecialchars($_GET['m']);
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
		</style>
</head>	
<body>
	<div class="container-fluid">
 <div class="row">
            <div class="span12">
<form action="login.php" method="post" id="loginform" class="form-horizontal">
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
</div></div></div>
</form>
</body>
</html>	