<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<link href="styles/styles.css" rel="stylesheet" media="screen" />
</head>	
<body>
	<div class="container-fluid">
	   	<div class="navbar navbar-fixed-top navbar-inverse" id="header">
 			<div class="navbar-inner text-center" id="menubar">
    			<a class="brand" href="index.php" id="titlebar">
    				<img src="images/logo-200.gif" style="width: 40px; height:40px;"/>
    				BAC
    			</a>
   				<ul class="nav">
					<li><a href="index.php">Home</a></li>
					<li><a href="pages.php">Pages</a></li>
					<li><a href="setup.php">Setup</a></li>
					<li><a href="help.php">Help</a></li>
   				</ul>
   				<div id="logout" class="pull-right">
					<a href="Http://<?php echo $_SERVER['HTTP_HOST']?>"><i class="icon-off invisible"></i> <?php echo $_SERVER['HTTP_HOST']?> <br /></a>
					<a href="logout.php"><i class="icon-off icon-white"></i> Logout</a>
   				</div>
   			</div>
    	</div>
		<div class="row-fluid">
			<div class="span10 offset1">
				<div id="content">