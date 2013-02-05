<?php
include_once('auth.php');
include_once('../src/util.php');


if(isset($_POST['submitted']))
{
	//process the form
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
			if($res){
				header("Location: " . get_absolute_uri('settings.php?m=Settings saved'));
			} else {
				header("Location: " .  get_absolute_uri('settings.php?m=Settings could not be saved'));
			}
		} else {
			//return 'error, passwords don't match' message
			header("Location: " .  get_absolute_uri('settings.php?m=Passwords do not match'));
		}
	}
	
} else {
	//show the form
	$message = '';
	if(isset($_GET['m']))
	{
		$message = $_GET['m'];
	}
	echo <<<EOM
	<html>
	<head>
	</head>
	<body>
	<p style="color:red;">{$message}</p>
	<p> Use this form to change administrative options </p>
	<form action={$_SERVER['PHP_SELF']} method="post">
		<p> Change administrative password: </p>
		New password:&nbsp;&nbsp;&nbsp; <input type="password" name="password"> <br />
		Repeat password : <input type="password" name="passwordConfirm"><br />
		<input type="submit" value="Save Changes">
		<input type="hidden" name="submitted" value="1">
	</form>
	</body>
	</html>
	
EOM;
}
?>