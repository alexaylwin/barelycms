<?php
/**This file is a blog bucket test **/
	//include 'auth.php';
	require_once __DIR__. '/../src/framework/classloader.php';
	
		$framework = new FrameworkController();
		$site = $framework->getSite();
		//$result = $site->addBucket('testBlogBucket', BucketTypes::Blog);
		$config['entryTemplate'] = "<h1>Title</h1><br /><div style=\"border:1px solid red;\">[entry]</div>";
		$config['sortOrder'] = "entryDate";
		$result = $site->addBucket('testBlogBucket', BucketTypes::Blog, $config);
		
		$blogBucket = $site->getBucket('testBlogBucket');
		
		$entry1 = new EntryBlock(date("Y/m/d"), "Alex", "Test", "entry1");
		$entry1->setValue("my awesome blog post 1");
	
		$entry2 = new EntryBlock(date("Y/m/d"), "Alex", "Test", "entry2");
		$entry2->setValue("my awesome blog post 2");
		
		$entry3 = new EntryBlock(date("Y/m/d"), "Alex", "Test", "entry3");
		$entry3->setValue("my awesome blog post 3");
		
		$blogBucket->addBlock($entry1);
		$blogBucket->addBlock($entry2);
		$blogBucket->addBlock($entry3);
		
		$blogid = '';
		$entrytemplate = '';
		$blocklist = '';
		
		$value = $blogBucket->render('');
		
?>

<html>
	<body>
		<table  style="border:1px solid black;">
			<tr style="border:1px solid black;"><th span="row"  style="border:1px solid black;">Blog bucket:</th><td style="border:1px solid black;"><?php var_dump($blogBucket)?></td></tr>
			<tr style="border:1px solid black;"><th span="row"  style="border:1px solid black;">Blog Rendering:</th><td style="border:1px solid black;"><?php echo $value;?></td></tr>
		</table>
	</body>
</html>

<?php
$site->removeBucket('testBlogBucket');
?>