<?php
	include 'auth.php';
	if(isset($_GET['editpage']))
	{
		$page = $_GET['editpage'];
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.copycss.js"></script>
		<script type="text/javascript" src="js/liveedit.js"></script>
		<script type="text/javascript" src="js/liveeditbootstrap.js"></script>
		<link rel="stylesheet" href="styles/liveedit_styles.css" />
		<script type="text/javascript">
			<!-- SERVER URL GOES HERE -->
			window.bac_jspath = "http://localhost:8888/barelycms/bac/admin/js";
		</script>
	</head>
	<body>
		<div id="edit-toolbar">BAC Toolbar</div>
		<iframe id="targetpage" src="http://<?php echo $page ?>"></iframe>
	</body>
</html>

<?php
	} else if(isset($_POST['savecontainer'])) {
		
	}
?>