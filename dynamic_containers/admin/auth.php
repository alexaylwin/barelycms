<?php
session_start();
include_once('../src/util.php');
/*
 * auth.php
 * 
 * This script verifies that a user is logged in and, if not, sends them
 * to the login page. It must be included in every file that should be 
 * protected from unauthorized access (ie, all admin scripts/files)
 * 
 */
 
 //we need to check the sesssion to ensure that A) it matchees the user id that was signed in with

if(!isset($_SESSION['UID']))
{
	header("Location: " . get_absolute_uri('login.php'));
}
?>