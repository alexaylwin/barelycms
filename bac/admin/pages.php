<?php
include 'auth.php';
include '../src/framework/classloader.php';
include 'scripts/pages_cbs.php';

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
<script type="text/javascript">
	function pageModal(pageid)
	{
		$('#pagemodal').modal();
		$('#pagename').text(pageid);
		$('#pageid').val(pageid);
	}
	
</script>
<h4>Pages</h4>
<p>
Please select the container that you'd like to edit:
</p>
<ul class="inline" id="pagelist">
	<?php
	foreach ($pagelist as $page) {
		echo '<li>';
		echo '<h5>' . $page->getPageId() . '<a class="icon" onclick="javascript:pageModal(\''. $page->getPageId() . '\');"><i class="icon-align-justify icon-white"></i></a><a class="icon" ><i class="icon-edit icon-white"></i></a></h5>';
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

<div id="pagemodal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
		</button>
		<h3>Edit Page Properties</h3>
	</div>
	<div class="modal-body">
		<p>
			<form id="pageproperties">
				Name: <span id="pagename"></span><br />
				<label class="control-label" for"pageurl">Page Live Edit URL: </label><input type="text" id="pageurl" />
				<input type="hidden" id="pageid" />
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" id="cancel" data-dismiss="modal" aria-hidden="true">Cancel</a>
		<a href="#" class="btn btn-primary" id="continue">Save</a>
	</div>
</div>
<?php
include 'footer.php';
?>
