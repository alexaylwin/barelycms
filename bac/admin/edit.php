<?php
include 'auth.php';
include '../src/framework/classloader.php';

if (!isset($_GET['container']) || !isset($_GET['page'])) {
	throw_error("container or page does not exist.", get_absolute_uri("listcontainers.php"));
}

$containerid = $_GET['container'];
$pageid = $_GET['page'];

$site = FrameworkController::loadsite();
$page = $site -> getPage($pageid);
$container = $page -> getContainer($containerid);
$text = $container -> getValue();
$displaymessage = "none";

$livelink = '';
if($page->canLiveEdit())
{
	$liveurl = $page->getLiveUrl();
	$livelink = <<<EOM
LiveEdit this page: <a href="liveedit.php?page={$liveurl}">{$liveurl}</a> 
<br />
EOM;
}

/**
 * If we have the post value, this means update the container.
 */
if (isset($_POST['container_content'])) {
	$container -> setValue($_POST['container_content']);
	$text = $container -> getValue();
	$message = "Container content saved.";
	$displaymessage = "block";
}
?>

<?php
include 'header.php';
?>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#container_content").width($("#content").width()-30);
		CKEDITOR.replace('container_content');
	});

</script>
<h4>Edit Container</h4>
<?php echo $livelink ?>
<div class="alert alert-success" style="display:<?php echo $displaymessage; ?>;">
	<?php echo $message; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<form id="containerform" action="edit.php?page=<?php echo $pageid; ?>&container=<?php echo $containerid; ?>" method="post">
	<textarea id="container_content" cols=50 rows=10 name="container_content"><?php echo $text; ?></textarea>
	<br />
	<br />
	<button id="submit" class="btn btn-custom">Save Changes</button>
</form>
<?php
include 'footer.php';
?>