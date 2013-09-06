<?php
include 'auth.php';
require __DIR__ . '/handlers/EditHandler.php';

//Initialize the CBS class
$requestHandler = new EditHandler();

$data = $requestHandler->handleRequest($_POST, $_GET);

if(isset($data['error']))
{
	throw_error('No Block was found with that ID', "buckets.php");
}

//Set up the message variables
$displaymessage = 'none';
$messageclass = 'alert-success';
$message = "Block content saved.";
$livelink = '';

if(!empty($data['postSuccess']))
{
	if($data['postSuccess'])
	{
		$displaymessage = 'block';
	}	else {
		$message = "Block content could not be saved";
		$messageclass = 'alert-failure';
		$displaymessage = 'block';
	}
} 

//If we have a live link url, set up the link
if(isset($data['liveurl']))
{
	$livelink = <<<EOM
	You can also Live Edit this page: <a href="liveedit.php?page={$data['liveurl']}">{$data['liveurl']}</a> 
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
		$("#block_content").width($("#content").width()-30);
		CKEDITOR.replace('block_content');
	});

</script>
<h4>Edit Block - <?php echo $data['bucketid']; ?> - <?php echo $data['blockid']; ?></h4>
<div class="alert <?php echo $messageclass?>" style="display:<?php echo $displaymessage; ?>;">
	<?php echo $message; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<form id="blockform" action="edit.php?block=<?php echo $data['blockid']; ?>&bucket=<?php echo $data['bucketid']; ?>" method="post">
	<textarea id="block_content" cols=50 rows=10 name="block_content"><?php echo $data['text']; ?></textarea>
	<input type="hidden" name="block" value="<?php echo $data['blockid']; ?>" />
	<input type="hidden" name="bucket" value="<?php echo $data['bucketid']; ?>" />
	<div>
		<br />
		<?php echo $livelink ?>
		<br />
		<button type="submit" id="submit" class="btn btn-custom pull-right">Save Changes</button>
		<a href="buckets.php"><button id="back" class="btn" type="button">Back</button></a>
	</div>
</form>
<?php
include 'footer.php';
?>