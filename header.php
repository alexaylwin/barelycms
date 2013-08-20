<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>BarelyACMS</title>

		<!-- jQuery, Bootstrap and Google fonts -->
		<script type="text/javascript" src="jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Cuprum:400,700' rel='stylesheet' type='text/css'>
		<!-- Style sheet -->
		<link href="static/styles/framework.css" rel="stylesheet" media="screen" />
		<?php
			if(isset($p) && $p == 'index')
			{
				echo '<link href="static/styles/splash.css" rel="stylesheet" media="screen" />';
			} else {
				echo '<link href="static/styles/content.css" rel="stylesheet" media="screen" />';
			}
		?>
		
		<!-- BAC loader -->
		<script type="text/javascript" src="bac/loader.js"></script>
	</head>
	
	<body>
	<div id="body">
		<div class="navbar">
			<div class="navbar-inner" id="menubar">
				<div id="logo">
					<a href="index.php"><img src="static/img/logo-200.gif"></a>
				</div>
				<ul class="nav">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="download.php">Download</a>
					</li>
					<li>
						<a href="started.php">Getting Started</a>
					</li>
					<li>
						<a href="support.php">Documentation/Support</a>
					</li>
					<li>
						<a href="try.php">Demo</a>
					</li>
					<li>
						<a href="about.php">About</a>
					</li>
				</ul>
			</div>
		</div>