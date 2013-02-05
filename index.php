<html>
<head>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
		$.get(	"bac/load_container.php", 
				{ page:"index", container:"mainbody" }, 
				function(data)
				{
					$('#content').html(data);
				}
		);
	
	/*
	$.ajax({
		url:"bac/load_container.php",
		timeout:1000,
		data: { page:"index", container:"mainbody" }
	}).done(function(data){
		$('#content').html(data);
	});
	*/
	
})
</script>
</head>
<body>
	<div id="content">
		
	</div>
</body>
</html>