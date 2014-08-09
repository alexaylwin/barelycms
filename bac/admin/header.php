<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
		<?php
			if(isset($BAC_TITLE_TEXT))
			{
				echo '<title>' . $BAC_TITLE_TEXT . '</title>';
			} else {
				echo '<title>BarelyACMS</title>';
			}
		?>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		
		<script src="jqueryui/jquery-ui.js"></script>
		<link href="jqueryui/jquery-ui.css" rel="stylesheet" />
	
		<link href="styles/styles.css" rel="stylesheet" media="screen" />
</head>	
<body>
	<div class="container-fluid">
	   	<div class="navbar navbar-fixed-top navbar-inverse" id="header">
 			<div class="navbar-inner text-center" id="menubar">
    			<a class="brand" href="index.php" id="titlebar">
    				<img src="images/logo-200.gif"/>
    				BAC
    			</a>
   				<ul class="nav">
					<li><a href="index.php">Home</a></li>
					<li><a href="buckets.php">Buckets</a></li>
					<li><a href="setup.php">Setup</a></li>
					<li><a href="help.php">Help</a></li>
   				</ul>
   				<div id="logout" class="pull-right text-left">
					Domain:<a href="http://<?php echo $_SERVER['HTTP_HOST']?>"><?php echo $_SERVER['HTTP_HOST']?></a><br />
					Logged in as: <?php echo $_SESSION['UID']; ?><br />
					<a href="logout.php"><i class="icon-off icon-white"></i> Logout</a>
   				</div>
   			</div>
    	</div>
		<div class="row-fluid">
			<div class="span10 offset1">
				<div id="content">