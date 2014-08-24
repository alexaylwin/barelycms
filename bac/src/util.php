<?php
include_once ('framework/Constants.php');
function get_absolute_uri($target)
{
	/* Redirect to a different page in the current directory that was requested */
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	
	return "http://$host$uri/$target";
}

function get_home_directory()
{
	
	return $dir;
}

function throw_error($message, $backpage)
{
	//redirect to error page
	$_SESSION['m'] = $message;
	$_SESSION['bp'] = get_absolute_uri($backpage);
	
	header("Location: " . get_absolute_uri("error.php"));
}

function auth_exists()
{
	$path = Constants::GET_CONFIG_DIRECTORY() . '/cred.php';
	if (file_exists($path)) {
		return true;
	} else {
		return false;
	}
}

function get_bac_uri($target)
{
	$host  = $_SERVER['HTTP_HOST'];
	$path = dirname(__FILE__);
	$path = dirname($path);
	//$path = substr( __FILE__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
	$path = substr($path, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
	return "http://$host/$path$target";
}
?>
