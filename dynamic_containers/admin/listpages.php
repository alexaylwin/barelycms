<?php
include 'auth.php';
include '../src/framework/classloader.php';

 $site = FrameworkController::loadsite();
 $pagelist = $site->getAllPages();
 
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/styles.css" />
	</head>
	
	<body>
		<div id="content">
		<h1> Edit a page</h1>
		
		<ul>
		<?php
			//foreach($pagename_array as $name)
			//{
			foreach($pagelist as $page)
			{
				echo '<li> <a href="listcontainers.php?pagename=' . $page->getPageId() . '"> ' . $page->getPageId() . ' </a></li>';
			}
		?>
		</ul>
		</div>
	</body>
	
	
</html>
