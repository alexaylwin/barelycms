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
		if($bucket->hasBlocks())
		{
			$blockListHtml = '<div id="' . $bucket->getBucketId() . '"><ul class="blocklist">';
			$blocklist = $bucket->getAllBlocks();
			
			foreach($blocklist as $block)
			{
				$blockListHtml .= '<li> <a href="edit.php?block=' . $block->getBlockId() . '&bucket='.$bucket->getBucketId().'"> ' . $block->getBlockId() . ' <i class="icon-edit icon-white"></i></a></li>';
				$i++;
			}
			$blockListHtml .= '</ul>';
			//$blockListHtml .= '<a href="#">Add Block</a>';
			$blockListHtml .= '</div>';
			$blockListHtmlArray[] = $blockListHtml;
		}
	}
	$bucketListHtml .= '</ul>';

	
?>

<?php
include 'header.php';
?>
<script type="text/javascript">
	function bucketPropertiesModal(bucketid, pageurl)
	{
		$('#bucketPropertiesModal').modal();
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
						$($("a[href='#"+result.bucketId+"']").siblings()[3]).attr('href', "liveedit.php?page=" + result.liveUrl);
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
	
	$('#tabs')
    .tabs()
    .addClass('ui-tabs-vertical ui-helper-clearfix');
});

</script>
<h4>Buckets</h4>

<style>
/**
 * Make tabs vertical
 */
.ui-widget-content
{
	background:#3b3b3b;
}
.ui-tabs.ui-tabs-vertical {
    padding: 0;
}
.ui-tabs.ui-tabs-vertical .ui-widget-header {
    border: none;
}
.ui-tabs.ui-tabs-vertical .ui-tabs-nav {
    float: left;
    width: 10em;
    background: #3b3b3b;
    border-radius: 4px 0 0 4px;
    border-right: 1px solid gray;
}
.ui-tabs.ui-tabs-vertical .ui-tabs-nav li {
    clear: left;
    width: 100%;
    margin: 0.2em 0;
    border: 1px solid gray;
    border-width: 1px 0 1px 1px;
    border-radius: 4px 0 0 4px;
    overflow: hidden;
    position: relative;
    right: -2px;
    z-index: 2;
}

.ui-tabs .ui-tabs-nav li
{
	white-space:normal;
}


.ui-tabs.ui-tabs-vertical .ui-tabs-nav li a {
    display: block;
    padding: 0.6em 1em;
    width:100%;
}

.ui-tabs.ui-tabs-vertical .ui-tabs-nav li a.tool  {
	width:100%;
	display:inline-block;
	padding-left: 0.6em;
	padding-top:1px;
	padding-bottom:1px;
	line-height:10px;
	font-size:10px;
}

.ui-tabs.ui-tabs-vertical .ui-tabs-nav li a:hover {
    cursor: pointer;
    border-bottom: 0;
	color: #838fff;
}
.ui-tabs.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active {
    margin-bottom: 0.2em;
    padding-bottom: 0;
    border-right: 1px solid #3b3b3b;
    text-decoration:none;
}

.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active
{
	background:#3b3b3b;
	
}
.ui-tabs.ui-tabs-vertical .ui-tabs-nav li:last-child {
    margin-bottom: 10px;
}
.ui-tabs.ui-tabs-vertical .ui-tabs-panel {
    float: left;
    border-left: 1px solid gray;
    border-radius: 0;
    position: relative;
    left: -1px;
}

.blocklist
{
	text-decoration:none;
}
	
</style>

<div id="tabs">
	<?php echo $bucketListHtml;
   		foreach($blockListHtmlArray as $blockHtml)
		{
			echo $blockHtml;	
		}
    ?>

	<!--
    <ul>
        <li>
            <a href="#a">Tab A</a>
        </li>
        <li>
            <a href="#b">Tab B</a>
        </li>
        <li>
            <a href="#c">Tab C</a>
        </li>
        <li>
            <a href="#d">Tab D</a>
        </li>
    </ul>
  
    <div id="a">
        Content of A
    </div>
    <div id="b">
        Content of B
    </div>
    <div id="c">
        Content of C
    </div>
    <div id="d">
        Content of D
    </div>
     -->
</div>

<p>
	To add a bucket or a block, go to the <a href="setup.php">setup page</a> to edit your sitemap.
</p>

<div id="bucketPropertiesModal" class="modal hide fade">
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