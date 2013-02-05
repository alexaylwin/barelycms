<?php
include 'auth.php';
include '../src/framework/classloader.php';
$site = FrameworkController::loadsite();

//Here we get the page name from the GET parameters, and retrieve all containers on that page
if(!isset($_GET['pagename']))
{
echo <<<EOM
<html>
	<head><link rel="stylesheet" type="text/css" href="styles/styles.css" /></head>
	<body>
	<div id="content">
		<h1> Edit container content </h1>
		
		<p> 
			Error - please return to the <a href="listpages.php"> page list </a>
		</p>
	</div>
	</body>
</html>	
EOM;
	return;	
}

$pagename = $_GET['pagename'];
$page = $site->getPage($pagename);
$containers = $page->getAllContainers();
?>

<html>
	<head><link rel="stylesheet" type="text/css" href="styles/styles.css" /></head>
	<body>
		<div id="content">
		<h1> Edit a page </h1>
		
		The following are the containers that can be edited on the selected page:
		<ul>
			
			<?php
			foreach($containers as $container)
			{
				echo '<li> <a href="editcontainer.php?container=' . $container->getContainerId() . '&page='.$pagename.'"> ' . $container->getContainerId() . ' </a></li>';
			}
			
			
			?>
			
		</ul>
		</div>
		
	</body>
	
	
	
</html>