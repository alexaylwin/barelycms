<?php
	if(isset($_GET['editpage']))
	{
		$page = $_GET['editpage'];
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/liveedit.js"></script>
		<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
		<link rel="stylesheet" href="styles/liveedit_styles.css" />
		<script type="text/javascript">
			window.bac_jspath = "localhost:8888/barelyacms/admin/bac/js/";
		</script>
	</head>
	<body style="margin:0; padding:0; overflow:hidden;">
		<iframe id="targetpage" style="width:100%; height:100%" src="http://<?php echo $page ?>"></iframe>
	</body>
</html>

<?php
	} else if(isset($_POST['savecontainer'])) {
		
	}
?>