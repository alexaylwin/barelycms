<?php
include 'auth.php';
include '../src/framework/classloader.php';
$site = FrameworkController::loadsite();
$pagelist = $site -> getAllPages();

$maxcontainers = 0;
foreach($pagelist as $page)
{
	$containerlist = $page->getAllContainers();
	if(count($containerlist) > $maxcontainers)
	{
		$maxcontainers = count($containerlist);
	}
}

include 'header.php';
?>
<h4>Pages</h4>
<p>
Please select the container that you'd like to edit:
</p>
<ul class="inline" id="pagelist">
	<?php
	foreach ($pagelist as $page) {
		echo '<li>';
		echo '<h5>' . $page->getPageId() . '</h5>';
		echo '<ul class="unstyled">';
		$i = 0;
		if($page->hasContainers())
		{
		$containerlist = $page->getAllContainers();
		
		foreach($containerlist as $container)
		{
			echo '<li> <a href="edit.php?container=' . $container->getContainerId() . '&page='.$page->getPageId().'"> ' . $container->getContainerId() . ' <i class="icon-edit icon-white"></i></a></li>';
			$i++;
		}
		}
		for($i = $i; $i < $maxcontainers; $i++)
		{
			echo '<li>&nbsp;</li>';
		}
		echo '</ul>';
		echo '</li>';
	}
	
	?>
</ul>

<p>
	To add a page or a container, go to the <a href="setup.php">setup page</a> to edit your sitemap.
	
</p>

<?php
include 'footer.php';
?>
