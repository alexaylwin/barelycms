<?php
include 'auth.php';
include '../src/framework/classloader.php';
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/styles.css" />
</head>

<body>
	<div id="content">
	<h1> NWR Painting Administration</h1>
	
		<p> 
		This page is used for administrative tasks. From here, you can configure some site settings, 
		edit any predefined content panel, or change the administration password. <br />
		To edit a page, click on 'Edit a page' from the list below.
		</p>
		Administrative tasks:
		<ul>
			<li><a href="listpages.php">Edit a page</a></li>
			<li>Change admin password</li>
			<li><a href="logout.php">Log out</a></li>
			
		</ul>
	</div>
</body>

</html>