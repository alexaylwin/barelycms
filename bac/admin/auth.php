<?php
include_once('../src/util.php');
require_once('../src/authentication/User.php');
require_once('../src/authentication/UserTypes.php');
require_once('../src/authentication/ActionPermissions.php');
require_once('../src/authentication/PagePermissions.php');
/*
 * auth.php
 * 
 * This script verifies that a user is logged in and, if not, sends them
 * to the login page. It must be included in every file that should be 
 * protected from unauthorized access (ie, all admin scripts/files)
 * 
 */
 
 //we need to check the sesssion to ensure that A) it matchees the user id that was signed in with
if(session_id() == '') {
    session_start();
}
if(isset($_SESSION['UID']) && isset($_SESSION['USER']) && isUserObjectValid())
{
	$GLOBALS['BAC_PAGE_PERMISSIONS'] = setPagePermissions();
} else {
	header("Location: " . get_absolute_uri('login.php'));
	die();
}

function setPagePermissions()
{
	$uri = $_SERVER['REQUEST_URI'];
	$page = strrchr($uri, '/');
	$page = substr($page, 1, strrpos($page, '.') - 1);
	return $_SESSION['USER']->getPagePermission($page);
}

//TODO: validate the user object held in the session
function isUserObjectValid()
{
	return true;
}
?>