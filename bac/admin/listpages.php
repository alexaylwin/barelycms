<?php
include 'auth.php';
include '../src/framework/classloader.php';
$site = FrameworkController::loadsite();
$pagelist = $site -> getAllPages();
include 'header.php';
?>

<ul>
	<?php
	//foreach($pagename_array as $name)
	//{
	foreach ($pagelist as $page) {
		echo '<li> <a href="listcontainers.php?pagename=' . $page -> getPageId() . '"> ' . $page -> getPageId() . ' </a></li>';
	}
	?>
</ul>

<?
include 'footer.php';
?>
