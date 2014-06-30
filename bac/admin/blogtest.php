<?php
/**This file is a blog bucket test **/
	include 'auth.php';
	require_once __DIR__. '/../src/framework/classloader.php';
	
		$framework = new FrameworkController();
		$site = $framework->getSite();
		$blogBucket = $site->getBucket('testBlogBucket');
		
		$blogid;
		$entrytemplate;
		$blocklist;
		
?>

<html>
	<body>
		<table>
			<tr><th span="row">Blog Bucket Id:</th><td><?php echo $blogid?></td></tr>
			<tr><th span="row">Blog Entry Template:</th><td><?php echo $entrytemplate?></td></tr>
			<tr><th span="row">Blog Blocks:</th><td><?php var_dump($blocklist)?></td></tr>
		</table>
	</body>
</html>