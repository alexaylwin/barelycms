<!DOCTYPE html>
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
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="styles/newui.css" />
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
</head>	
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
					aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
				<a class="navbar-brand" href="#"><img src="images/logo-200.gif" style="height: 100%;" /></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Home</a></li>
					<li><a href="buckets.php">Buckets</a></li>
					<li><a href="settings.php">Settings</a></li>
					<li role="separator" class="divider"></li>					
					<li><a href="help.php">Help</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Logged In As: <?php echo $_SESSION['UID']; ?></a></li>
							<li><span>Domain: <a href="http://<?php echo $_SERVER['HTTP_HOST']?>"><?php echo $_SERVER['HTTP_HOST']?></a></span></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout.php">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-1"></div>