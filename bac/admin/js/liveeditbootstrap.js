$(document).ready(function()
{
	var jspath = document.location.href.substring(0, document.location.href.indexOf('liveedit.php')) + 'js/';
	$('#bac-targetpage').load(function(){
        $('#bac-targetpage').contents().find('body').before('<style>.bac-hoveroverlay{}.liveeditor{}</style>');
	});

});