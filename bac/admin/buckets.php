<?php
/**
 * This sets up the authentication and queries the CBS for view data
 */
	include 'auth.php';
	require __DIR__ . '/handlers/BucketsHandler.php';
	
	$requestHandler = new BucketsHandler();
	$data = $requestHandler->handleRequest($_POST, $_GET);
	
	if(isset($data['ajax']))
	{
		echo json_encode($data['data']);
		die();
	}
	
	$bucketlist = $data['bucketlist'];
	$maxblocks = $data['maxblocks'];
	
	//$list = '';
	$bucketListHtml = '';
	$blockListHtmlArray = Array();
	
	//Build the bucket/block form
	//This is very tightly coupled to the presentation of the list (classes etc.)
	//so it stays in the view
	$bucketListHtml = '<ul>';
	foreach ($bucketlist as $bucket) {
		
		$bucketListHtml .= '<li>';
		
		$bucketListHtml .=  
						'<a href="#'. $bucket->getBucketId() .'">' . 
							$bucket->getBucketId() . 
						'</a> <br />' . 
						'<a class="icon properties tool" onclick="javascript:bucketPropertiesModal(\''. $bucket->getBucketId() . '\', \''. $bucket->getLiveUrl() . '\');">'.
							'<i class="icon-align-justify icon-white"></i> Properties'.
						'</a> <br />' .
						'<a href="liveedit.php?page=' . $bucket->getLiveUrl() . '" class="icon liveurl tool" >' .
							'<i class="icon-edit icon-white"></i> LiveEdit' .
						'</a>';
						
		$bucketListHtml .= '</li>';
		$i = 0;
		
		$blockListHtml = '<div id="' . $bucket->getBucketId() . '"><ul class="blocklist">';
		if($bucket->hasBlocks())
		{
			$blocklist = $bucket->getAllBlocks();
			
			foreach($blocklist as $block)
			{
				$blockListHtml .= '<li>';
				$blockListHtml .= '<a href="edit.php?block=' . $block->getBlockId() . '&bucket=' . $bucket->getBucketId() . '"> ' . $block->getBlockId() . ' <i class="icon-edit icon-white"></i></a>&nbsp;';
				
				if($GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('deleteBlock') > 0)
				{	
					$blockListHtml .= '&nbsp;<a href="javascript:deleteBlock(\''.$block->getBlockId() .'\', \'' .$bucket->getBucketId().'\')">[X]</a>';
				}
				
				$blockListHtml .= '</li>';
				
				$i++;
			}
		}
		$blockListHtml .= '</ul>';
		if($GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('createBlock') > 0)
		{
			$blockListHtml .= '<a href="javascript:addBlockModal(\''.$bucket->getBucketId().'\');">Add Block</a>';
		}
		$blockListHtml .= '</div>';
		$blockListHtmlArray[] = $blockListHtml;
		
	}

	$bucketListHtml .= '</ul>';

	
?>

<?php
$BAC_TITLE_TEXT = "BarelyACMS - Buckets";
include 'header.php';
?>
<link rel="stylesheet" href="styles/buckets.css" />
<script type="text/javascript">
	function bucketPropertiesModal(bucketid, pageurl)
	{
		$('#bucketPropertiesModal').modal();
		$('#bucketProperties > .modal-bucket-name').text(bucketid);
		$('#bucketProperties > #propertiesBucketId').val(bucketid);
		$('#bucketProperties > #pageurl').val(pageurl);
		$("#bucketPropertiesModal > .modal-body > .modal-message").css("display", "none");
		$(document).keypress(function(e){
  			if (e.which == 13){
   		    	$("#bucketPropertiesModal > #saveProperties").click();
    		}
		});
	}
	
	function addBlockModal(bucketid)
	{
		$('#addBlockModal').modal();
		$('#newBlockProperties > .modal-bucket-name').text(bucketid);
		$('#newBlockProperties > #addBlockBucketId').val(bucketid);
		$('#newBlockProperties > #newblockid').val('');
		$("#addBlockModal > .modal-body > .modal-message").css("display", "none");
		$(document).keypress(function(e){
  			if (e.which == 13){
   		    	$("#addBlockModal > #addBlock").click();
    		}
		});
	}
	
	function deleteBlock(blockid, bucketid)
	{
		$("#deleteBlockModal").modal();
		$('#deleteBlockProperties > .modal-bucket-name').text(bucketid);
		$('#deleteBlockProperties > .modal-block-name').text(blockid);
		$('#deleteBlockProperties > #deleteBlockBucketId').val(bucketid);
		$('#deleteBlockProperties > #deleteBlockBlockId').val(blockid);
		$(document).keypress(function(e){
  			if (e.which == 13){
   		    	$("#deleteBlockModal > #deleteBlock").click();
    		}
		});
	}
	

$(document).ready(function(){
	$("#saveProperties").click(function(){
		var formdata = $("#bucketProperties").serialize();
		$.post("buckets.php?a=1", 
				formdata, 
				function(data)
				{
					var result = JSON.parse(data);
					if(result.success == 1)
					{
						$($("a[href='#"+result.bucketId+"']").siblings()[3]).attr('href', "liveedit.php?page=" + result.liveUrl);
						$("#bucketPropertiesModal > .modal-body > .modal-message").css("display", "block");
						$("#bucketPropertiesModal > .modal-body > .modal-message > .modal-message-body").html("Properties saved");
					} else {
						$("#bucketPropertiesModal > .modal-body > .modal-message").removeClass("alert-success");
						$("#bucketPropertiesModal > .modal-body > .modal-message").addClass("alert-error");
						$("#bucketPropertiesModal > .modal-body > .modal-message-body").html("Properties could not be saved");
						$("#bucketPropertiesModal > .modal-body > .modal-message").css("display", "block");
					}
				}
		);
		
	});
	
	$("#addBlock").click(function(){
		var formdata = $('#newBlockProperties').serialize();
		$.post('buckets.php?a=1',
			formdata,
			function(data)
			{
				var result = JSON.parse(data);
				if(result.success == 1)
				{
					//Add the new block link to the list of blocks for this bucket
					var bucketid = $('#newBlockProperties > #addBlockBucketId').val();
					var blockid = $('#newBlockProperties > #newblockid').val();
					var newBlockLink = '<li> <a href="edit.php?block=' + blockid + '&bucket='+bucketid+'"> ' +blockid+ ' <i class="icon-edit icon-white"></i></a>&nbsp;'
										+ '&nbsp;<a href="javascript:deleteBlock(\''+blockid+'\', \'' +bucketid+'\')">[X]</a></li>';
					$('#'+bucketid + ' > .blocklist').append(newBlockLink);
					
					$("#addBlockModal > .modal-body > .modal-message").css("display", "block");
					$("#addBlockModal > .modal-body > .modal-message > .modal-message-body").html("Block Added");
				} else {
					$("#addBlockModal > .modal-body > .modal-message").removeClass("alert-success");
					$("#addBlockModal > .modal-body > .modal-message").addClass("alert-error");
					$("#addBlockModal > .modal-body > .modal-message > .modal-message-body").html("Block could not be added");
					$("#addBlockModal > .modal-body > .modal-message").css("display", "block");

				}
			}
		);
	});
	
	$("#deleteBlock").click(function(){
		var formdata = $('#deleteBlockProperties').serialize();
		formdata += "&deleteBlock=1";
		$.post("buckets.php?a=1",
				formdata,
				function(data)
				{
					console.log(data);
					var result = JSON.parse(data);
					if(result.success == 1)
					{
						var bucketid = $('#deleteBlockProperties > #deleteBlockBucketId').val();
						var blockid = $('#deleteBlockProperties > #deleteBlockBlockId').val();
						$('#'+bucketid + ' > .blocklist').find(':contains("'+blockid+'")').remove();
						$("#deleteBlockModal").modal('hide');
					} else {
						$("#deleteBlockModal > .modal-body > .modal-message").removeClass("alert-success");
						$("#deleteBlockModal > .modal-body > .modal-message").addClass("alert-error");
						$("#deleteBlockModal > .modal-body > .modal-message > .modal-message-body").html("Block could not be deleted");
						$("#deleteBlockModal > .modal-body > .modal-message").css("display", "block");
					}
				}
		);

	});
	
	$('#tabs')
    .tabs()
    .addClass('ui-tabs-vertical ui-helper-clearfix');
});

</script>
<h4>Buckets</h4>

<div id="tabs">
	<?php 
	
		echo $bucketListHtml;
   		
   		foreach($blockListHtmlArray as $blockHtml)
		{
			echo $blockHtml;	
		}
    ?>
</div>

<p>
	To add a bucket or a block, go to the <a href="setup.php">setup page</a> to edit your sitemap.
</p>

<!-- Bucket Properties modal window -->
<div id="bucketPropertiesModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Edit Bucket Properties</h3>
	</div>
	<div class="modal-body">
		<div class="modal-message alert alert-success" style="display:none;">
			<span class="modal-message-body"></span>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<p>
			<form id="bucketProperties">
				Bucket Name: <span class="modal-bucket-name"></span><br />
				<span class="control-label">Page Live Edit URL: </span> <input type="text" id="pageurl" name="pageurl" />
				<input type="hidden" id="propertiesBucketId" name="propertiesBucketId"/>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
		<a href="#" class="btn btn-primary" id="saveProperties">Save</a>
	</div>
</div>

<!-- Add Block modal window-->
<div id="addBlockModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Add Block</h3>
	</div>
	<div class="modal-body">
		<div class="modal-message alert alert-success" style="display:none;">
			<span class="modal-message-body"></span>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<p>
			<form id="newBlockProperties">
				Bucket Name: <span class="modal-bucket-name"></span><br />
				Block Type: Text<br />
				<span class="control-label">Block name:</span> <input type="text" id="newblockid" name="newblockid" />
				<input type="hidden" id="addBlockBucketId" name="addBlockBucketId"/>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
		<a href="#" class="btn btn-primary" id="addBlock">Add Block</a>
	</div>
</div>

<!-- Delete Block modal window-->
<div id="deleteBlockModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Delete Block</h3>
	</div>
	<div class="modal-body">
		<div class="modal-message alert alert-error">
			<span class="modal-message-body">Are you sure you want to delete this block?</span>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<p>
			<form id="deleteBlockProperties">
				Bucket Name: <span class="modal-bucket-name"></span><br />
				Block Name: <span class="modal-block-name"></span><br />

				<input type="hidden" id="deleteBlockBlockId" name="deleteBlockBlockId" />
				<input type="hidden" id="deleteBlockBucketId" name="deleteBlockBucketId" />
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
		<a href="#" class="btn btn-primary" id="deleteBlock">Delete Block</a>
	</div>
</div>

<?php
include 'footer.php';
?>