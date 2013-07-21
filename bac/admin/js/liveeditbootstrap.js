$(document).ready(function()
{
	var jspath = document.location.href.substring(0, document.location.href.indexOf('liveedit.php')) + 'js/';
	$('#targetpage').load(function(){
        $('#targetpage').contents().find('body').before('<style>.bac-hoveroverlay{border:1px solid red;}.liveeditor{}</style>');
        // $('#targetpage').contents().find('body').before('<script type="text/javascript">window.bac_jspath="'+jspath+'"</script>')
		// $('#targetpage').contents().find('body').before('<script type="text/javascript" src="'+jspath+'jquery.min.js"></script>');
        // $('#targetpage').contents().find('body').before('<script type="text/javascript" src="'+jspath+'tiny_mce/tiny_mce.js"></script>');
        // $('#targetpage').contents().find('body').before('<script type="text/javascript" src="'+jspath+'liveedit.js"></script>');
	});

});