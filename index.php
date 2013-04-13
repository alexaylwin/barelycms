<html>
<head>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="bac/loader.js"></script>
<script type="text/javascript">

/*
$(document).ready(function() {
		$.get(	"bac/load_container.php", 
				{ page:"index", container:"mainbody" }, 
				function(data)
				{
					$('#content').html(data);
				}
		);
});
*/

</script>
</head>
<body data-bac-page="Index">
	<div id="mydiv" data-bac-id="mainbody"></div>
	<div id="otherdiv" data-bac-page="Second" data-bac-id="container"></div>
	<div id="content">
		<?php
		include('/bac/load.php');
		echo load_container('index', 'mainbody'); 
		?>
	</div>
</body>
</html>