<?php
include_once ('src/framework/classloader.php');
function load_container($pagename, $container) {
	$site = FrameworkController::loadsite();
	if ($site) {

		$page = $site -> getPage($pagename);
		if ($page) {

			$container = $page -> getContainer($container);
			if ($container) {
				return $container -> getValue();
			}
		}
	}
	//echo $container->getValue();

}

if (isset($_GET['page']) && isset($_GET['container'])) {
	echo load_container($_GET['page'], $_GET['container']);
} else if (isset($page) && isset($container)) {
	echo load_container($page, $container);
} else {
	echo "";
}
?>