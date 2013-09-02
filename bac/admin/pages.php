<?php
/**
 * This sets up the authentication and queries the CBS for view data
 */
	include 'auth.php';
	require __DIR__ . '/handlers/PagesHandler.php';
	
	$requestHandler = new pagesHandler();
	$data = $requestHandler->handleRequest($_POST, $_GET);
	
	if(isset($data['ajax']))
	{
		echo json_encode($data['data']);
		die();
	}
	
	$pagelist = $data['pagelist'];
	$maxcontainers = $data['maxcontainers'];
	
	$list = '';
	
	//Build the page/containers form
	//This is very tightly coupled to the presentation of the list (classes etc.)
	//so it stays in the view
	foreach ($pagelist as $page) {
		$list = $list . '<li>';
		$list = $list . '<h5 id="'. $page->getPageId() .'">' . 
						$page->getPageId() . 
						'<a class="icon properties" onclick="javascript:pageModal(\''. $page->getPageId() . '\', \''. $page->getLiveUrl() . '\');">'.
						'<i class="icon-align-justify icon-white"></i>'.
						'</a>' .
						'<a href="liveedit.php?page=' . $page->getLiveUrl() . '" class="icon liveurl" ><i class="icon-edit icon-white"></i></a></h5>';
		$list = $list . '<ul class="unstyled">';
		$i = 0;
		if($page->hasContainers())
		{
			$containerlist = $page->getAllContainers();
			
			foreach($containerlist as $container)
			{
				$list = $list . '<li> <a href="edit.php?container=' . $container->getContainerId() . '&page='.$page->getPageId().'"> ' . $container->getContainerId() . ' <i class="icon-edit icon-white"></i></a></li>';
				$i++;
			}
		}
		for($i = $i; $i < $maxcontainers; $i++)
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
	function pageModal(pageid, pageurl)
	{
		$('#pagemodal').modal();
		$('#pagename').text(pageid);
		$('#pageid').val(pageid);
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
		var formdata = $("#pageproperties").serialize();
		$.post("pages.php?a=1", 
				formdata, 
				function(data)
				{
					var result = JSON.parse(data)
					if(result.success == 1)
					{
						$("#" + result.pageId + " > .liveurl").attr("href", "liveedit.php?page=" + result.liveUrl);
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
<h4>Pages</h4>
<p>
Please select the container that you'd like to edit:
</p>
<ul class="inline" id="pagelist">
	<?php echo $list ?>
</ul>

<p>
	To add a page or a container, go to the <a href="setup.php">setup page</a> to edit your sitemap.
</p>

<div id="pagemodal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Edit Page Properties</h3>
	</div>
	<div class="modal-body">
		<div id="modal-message" class="alert alert-success" style="display:none;">
			<span id="modal-message-body"></span>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<p>
			<form id="pageproperties">
				Page Name: <span id="pagename"></span><br />
				<span class="control-label">Page Live Edit URL: </span> <input type="text" id="pageurl" name="pageurl" />
				<input type="hidden" id="pageid" name="pageid"/>
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