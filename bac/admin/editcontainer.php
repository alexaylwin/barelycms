<?php
    include 'auth.php';
	include '../src/framework/classloader.php';
	
	
	if(!isset($_GET['container']) || !isset($_GET['page']))
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
	
	$containerid = $_GET['container'];
	$pageid = $_GET['page'];
	
	$site = FrameworkController::loadsite();
	$page = $site->getPage($pageid);
	$container = $page->getContainer($containerid);
	$text = $container->getValue();
	
	/**
	 * If we have the post value, this means update the container.
	 */
	if(isset($_POST['container_content']))
	{
		$container->setValue($_POST['container_content']);
		$text = $container->getValue();
	}
	
?>

<html>
	<head>
		<script type="text/javascript">
			function loadtext()
			{
				var textfield = document.getElementById("container_content");
				textfield.value ="<?php echo $text; ?>";
			}
			
		</script>
		<link rel="stylesheet" type="text/css" href="styles/styles.css" />
		
	</head>
	<body onload="javascript:loadtext();">
	<div id="content">
		<h1> Edit container content </h1>
		
		<p> 
			To edit the container content, use the textbox below and hit 'Update container'. The changes will take effect immediately.
			If you would like to preview your changes before you submit them, make your changes then hit the 'Preview' button.
		</p>
		
		<form id="containerform" action="editcontainer.php?page=<?php echo $pageid;?>&container=<?php echo $containerid; ?>" method="post">
			<div id="toolbar">
				<span class="editbar button" id="bold">|Bold|</span> <span class="editbar button" id="italic">|Italic|</span>
			</div>
			<textarea id="container_content" cols=50 rows=10 name="container_content"></textarea> <br /> <br />
			<input id="submit" type="submit" value="Update container" />			
		</form>
	</div>
	</body>
</html>