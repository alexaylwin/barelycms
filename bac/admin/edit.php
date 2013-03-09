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

/**
 * If we have the post value, this means update the container.
 */
if (isset($_POST['container_content'])) {
	$container -> setValue($_POST['container_content']);
	$text = $container -> getValue();
}
?>

<?php
include 'header.php';
?>
<script type="text/javascript" src="../admin/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#container_content").width($("#content").width()-30);
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../admin/js/tiny_mce/tiny_mce.js',

			setup : function(ed) {
				ed.onSaveContent.add(function(ed, o) {
				});
			},
			
			height : "300px",

			// General options
			theme : "advanced",
			plugins : "table, fullscreen, lists, autolink, advlink, advimage, searchreplace", //"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,fullscreen",//,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",

			// Example content CSS (should be your site CSS)
			content_css : "../admin/styles/editor_styles.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

		});
	});

</script>
<h4>Edit Container</h4>
<p>
	To edit the container content, use the textbox below and hit 'Update container'. The changes will take effect immediately.
	If you would like to preview your changes before you submit them, make your changes then hit the 'Preview' button.
</p>

<form id="containerform" action="edit.php?page=<?php echo $pageid; ?>&container=<?php echo $containerid; ?>" method="post">
	<textarea id="container_content" cols=50 rows=10 name="container_content" class="tinymce"><?php echo $text; ?></textarea>
	<br />
	<br />
	<button id="submit" class="btn btn-custom">Save Changes</button>
</form>
<?php
include 'footer.php';
?>