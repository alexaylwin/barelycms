<?php
/**
 * This sets up the authentication and queries the CBS for view data
 */
	include 'auth.php';
	require __DIR__ . '/handlers/BucketsHandler.php';
	
	$requestHandler = new bucketsHandler();
	$data = $requestHandler->handleRequest($_POST, $_GET);
	
	if(isset($data['ajax']))
	{
		echo json_encode($data['data']);
		die();
	}
	
	$bucketlist = $data['bucketlist'];
	$maxblocks = $data['maxblocks'];
	
	$list = '';
	
	//Build the bucket/block form
	//This is very tightly coupled to the presentation of the list (classes etc.)
	//so it stays in the view
	foreach ($bucketlist as $bucket) {
		$list = $list . '<li>';
		$list = $list . '<h5 id="'. $bucket->getBucketId() .'">' . 
						$bucket->getBucketId() . 
						'<a class="icon properties" onclick="javascript:bucketModal(\''. $bucket->getBucketId() . '\', \''. $bucket->getLiveUrl() . '\');">'.
						'<i class="icon-align-justify icon-white"></i>'.
						'</a>' .
						'<a href="liveedit.php?page=' . $bucket->getLiveUrl() . '" class="icon liveurl" ><i class="icon-edit icon-white"></i></a></h5>';
		$list = $list . '<ul class="unstyled">';
		$i = 0;
		if($bucket->hasBlocks())
		{
			$blocklist = $bucket->getAllBlocks();
			
			foreach($blocklist as $block)
			{
				$list = $list . '<li> <a href="edit.php?block=' . $block->getBlockId() . '&bucket='.$bucket->getBucketId().'"> ' . $block->getBlockId() . ' <i class="icon-edit icon-white"></i></a></li>';
				$i++;
			}
		}
		for($i = $i; $i < $maxblocks; $i++)
		{
			$list = $list . '<li>&nbsp;</li>';
		}
		$list = $list . '</ul>';
		$list = $list . '</li>';
	}
	
?>

<?php
include 'header.php';
?>
<script type="text/javascript">
	function bucketModal(bucketid, pageurl)
	{
		$('#bucketmodal').modal();
		$('#bucketname').text(bucketid);
		$('#bucketid').val(bucketid);
		$('#pageurl').val(pageurl);
		$("#modal-message").css("display", "none");
		$(document).keypress(function(e){
  			if (e.which == 13){
   		    	$("#save").click();
    		}
		});
	}
$(document).ready(function(){
	$("#save").click(function(){
		var formdata = $("#bucketproperties").serialize();
		$.post("buckets.php?a=1", 
				formdata, 
				function(data)
				{
					var result = JSON.parse(data)
					if(result.success == 1)
					{
						$("#" + result.bucketId + " > .liveurl").attr("href", "liveedit.php?page=" + result.liveUrl);
						$("#modal-message").css("display", "block");
						$("#modal-message-body").html("Properties saved");
					} else {
						$("#modal-message").removeClass("alert-success");
						$("#modal-message").addClass("alert-error");
						$("#modal-message-body").html("Properties could not be saved");
						$("#modal-message").css("display", "block");
					}
				}
		);
		
	});
});

</script>
<h4>Buckets</h4>
<p>
Please select the block that you'd like to edit:
</p>
<ul class="inline" id="bucketlist">
	<?php echo $list ?>
</ul>

<p>
	To add a bucket or a block, go to the <a href="setup.php">setup page</a> to edit your sitemap.
</p>

<div id="bucketmodal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Edit Bucket Properties</h3>
	</div>
	<div class="modal-body">
		<div id="modal-message" class="alert alert-success" style="display:none;">
			<span id="modal-message-body"></span>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<p>
			<form id="bucketproperties">
				Bucket Name: <span id="bucketname"></span><br />
				<span class="control-label">Page Live Edit URL: </span> <input type="text" id="pageurl" name="pageurl" />
				<input type="hidden" id="bucketid" name="bucketid"/>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" id="cancel" data-dismiss="modal" aria-hidden="true">Close</a>
		<a href="#" class="btn btn-primary" id="save">Save</a>
	</div>
</div>
<?php
include 'footer.php';
?>