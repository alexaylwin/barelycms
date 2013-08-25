<?php
include 'auth.php';
require __DIR__ . '/scripts/edit_cbs.php';

//Initialize the CBS class
$editcbs = new EditCBS();

//Set up the message variables
$displaymessage = 'none';
$messageclass = 'alert-success';
$message = "Container content saved.";

//If we're coming from a post, handle a post
if (isset($_POST['container_content'])) {
	$postSuccess = $editcbs->handlePost($_POST);
	if($postSuccess)
	{
		$displaymessage = 'block';
	} else {
		$message = "Container content could not be saved";
		$messageclass = 'alert-failure';
		$displaymessage = 'block';
	}
}

//Now get the normal view
$data = $editcbs->handleView($_GET);
if(isset($data['error']))
{
	throw_error('No container was found with that ID', "pages.php");
}

//If we have a live link url, set up the link
$livelink = '';
if(isset($data['liveurl']))
{
	$livelink = <<<EOM
	You can also Live Edit this page: <a href="liveedit.php?page={$liveurl}">{$liveurl}</a> 
	 <br />
EOM;
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
<h4>Edit Container - <?php echo $data['pageid']; ?> - <?php echo $data['containerid']; ?></h4>
<div class="alert <?php echo $messageclass?>" style="display:<?php echo $displaymessage; ?>;">
	<?php echo $message; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<form id="containerform" action="edit.php?container=<?php echo $data['containerid']; ?>&page=<?php echo $data['pageid']; ?>" method="post">
	<textarea id="container_content" cols=50 rows=10 name="container_content"><?php echo $data['text']; ?></textarea>
	<input type="hidden" name="container" value="<?php echo $data['containerid']; ?>" />
	<input type="hidden" name="page" value="<?php echo $data['pageid']; ?>" />
	<div>
		<br />
		<?php echo $livelink ?>
		<br />
		<button type="submit" id="submit" class="btn btn-custom pull-right">Save Changes</button>
		<a href="pages.php"><button id="back" class="btn" type="button">Back</button></a>
	</div>
</form>
<?php
include 'footer.php';
?>