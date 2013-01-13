<?php
session_start();
include_once('../src/util.php');

/*
 * this is the login form, it provides a secure way to access the application. it relies on the
 * lock.z file, which holds a hashed version of the password.
 */
if(!isset($_SESSION['UID']))
{
	if(isset($_POST['loginp']))
	{
		$file = fopen('../admin/lock/lock.z', 'r');
		$hashpwd = fread($file, filesize('../admin/lock/lock.z'));
 		
 		//this would be some hash function
		if($hashpwd == $_POST['loginp'])
		{
			$_SESSION['UID'] = $_POST['loginu'];
			header("Location: " .get_absolute_uri('admin_home.php'));
		} else {
			header("Location: " . get_absolute_uri('login.php?m=Bad Password'));
		}		
		
	}
	$message = '';
	if(isset($_GET['m']))
	{
		$message = $_GET['m'];
	}
echo <<<EOM
<html>
<head> <title> Login </title> </head>

<body>
<form action="login.php" method="post">
	<span style="color:red;">{$message}</span><br />
	<input type="text" value="username" name="loginu"/> <br />
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