<?php
session_start();
include_once('../src/util.php');

/*
 * this is the login form, it provides a secure way to access the application. it relies on the
 * lock.z file, which holds a hashed version of the password.
 */
if(!isset($_SESSION['UID']))
{
	if(isset($_POST['loginp']) && isset($_POST['loginu']))
	{
		//$file = fopen('../admin/lock/lock.z', 'r');
		//$hashpwd = fread($file, filesize('../admin/lock/lock.z'));
		$u = $_POST['loginu'];
		$p = $_POST['loginp'];
		$p = sha1($p);
 		include_once('../admin/lock/cred.php');

 		//this would be some hash function
		if($p == $password && $u == $username)
		{
			session_start();
			$_SESSION['UID'] = $_POST['loginu'];
			header("Location: " .get_absolute_uri('admin_home.php'));
		} else {
			header("Location: " . get_absolute_uri('login.php?m=Bad Password'));
			die();
		}		
		
	}
	$message = '';
	if(isset($_GET['m']))
	{
		$message = htmlspecialchars($_GET['m']);
	}
echo <<<EOM
<html>
<head> <title> Login </title> </head>

<body>
<form action="login.php" method="post">
	<span style="color:red;">{$message}</span><br />
	<input type="text" value="" name="loginu"/> <br />
	<input type="password" name="loginp"/> <br />
	<input type="submit" value="login"/>
</form>
</html>
EOM;
	
} else {
	//they're logged in, why are they back at the login page?
	//get back to home!
	header("Location: " .get_absolute_uri('admin_home.php'));
}
  
?>	