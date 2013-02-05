<?php
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
?>
