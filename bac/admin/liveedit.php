<?php
	include 'auth.php';
	include '../src/framework/classloader.php';
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="jqueryui/js/jquery-ui-1.10.3.custom.js"></script>
		<script type="text/javascript" src="js/liveedit.js"></script>
		<!-- <script type="text/javascript" src="js/liveeditbootstrap.js"></script> -->
		<script type="text/javascript" src="ckeditor-dev/ckeditor.js"></script>
		<link rel="stylesheet" href="styles/liveedit_styles.css" />
		<link rel="stylesheet" href="jqueryui/css/bac-edit/jquery-ui-1.10.3.custom.css" />
		<script type="text/javascript">
			<!-- SERVER URL GOES HERE -->
			window.bac_jspath = "http://localhost:8888/barelycms/bac/admin/js";
		</script>
	</head>
	<body>
		<div id="bac-edit-toolbar">BAC Toolbar</div>
		<div id="bac-mouseover"></div>
		<iframe id="bac-targetpage" src="http://<?php echo $page ?>"></iframe>
	</body>
</html>

<?php
	} else if(isset($_POST['containercontent']) && isset($_POST['containerid']) && isset($_POST['pageid'])) {
			
		$pageid = strtolower($_POST['pageid']);
		$containerid = strtolower($_POST['containerid']);
		$containercontent = $_POST['containercontent'];
		
		$site = FrameworkController::loadsite();
		$page = $site->getPage($pageid);
		
		if($page)
		{
			$container = $page -> getContainer($containerid);
			if($container)
			{
				$container-> setValue($containercontent);
				echo "1";
			}
		}
		
	}
?>