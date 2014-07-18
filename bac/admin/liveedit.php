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
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="ckeditor/adapters/jquery.js"></script>
		<script type="text/javascript" src="js/liveedit.js"></script>
		
		<link rel="stylesheet" href="styles/liveedit_styles.css" />
		<link rel="stylesheet" href="jqueryui/css/bac-edit/jquery-ui-1.10.3.custom.css" />
		<style>
			/**
				A hack to make the CKEEditor appear, and not float off screen.
			**/
			.cke {
				top: 0px !important;
				left: 0px !important;
			}
		</style>
	</head>
	<body>
<!--		<div id="bac-edit-toolbar">BAC Toolbar</div>
		<div id="bac-mouseover"></div>
-->
		<iframe id="bac-targetpage" src="<?php echo $page ?>"></iframe>
	</body>
</html>

<?php
	} else if(isset($_POST['blockcontent']) && isset($_POST['blockid']) && isset($_POST['bucketid'])) {
		
		$bucketid = $_POST['bucketid'];
		$blockid = $_POST['blockid'];

			
		//$bucketid = strtolower($_POST['bucketid']);
		//$blockid = strtolower($_POST['blockid']);
		$blockcontent = $_POST['blockcontent'];
		
		$framework = new FrameworkController();
		$site = $framework->getSite();
		if($site->hasBucket($bucketid))
		{
			$bucket = $site->getBucket($bucketid);
			if($bucket->hasBlock($blockid))
			{
				$block = $bucket->getBlock($blockid);
				$block->setValue($blockcontent);
				echo "1";
			} else {
				echo "0";
			}
		} else {
			echo "0";
		}
	}
?>