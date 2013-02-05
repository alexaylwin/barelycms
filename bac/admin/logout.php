<?php
	session_start();
	unset($_SESSION['UID']);
	session_destroy();
?>

<html>
	You are now logged out. To log in again, go to <a href="login.php">the login page.</a>	
</html>