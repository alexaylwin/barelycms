<html>
<head>
<script type="text/javascript" src="jquery.min.js"></script>
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
<body>
	<div id="content">
		<?php
		include('/bac/load_container.php');
		echo load_container('index', 'mainbody'); 
		//	$page = 'index';
		//	$container = 'mainbody';
		//	include('/bac/load_container.php');
		?>
	</div>
</body>
</html>