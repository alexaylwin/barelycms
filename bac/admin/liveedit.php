<?php
	if(isset($_GET['editpage']))
	{
		$page = $_GET['editpage'];
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.copycss.js"></script>
		<script type="text/javascript" src="js/liveedit.js"></script>
		<script type="text/javascript" src="js/tiny_mce/jquery.tinymce.js"></script>
		<link rel="stylesheet" href="styles/liveedit_styles.css" />
		<script type="text/javascript">
			window.bac_jspath = "http://localhost:8080/barelyacms/bac/admin/js";
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