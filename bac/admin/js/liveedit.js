$(document).ready(function()
{	
		
	function editmouseover()
	{
		$(this).addClass('bac-hoveroverlay');
	}
	
	function editmouseout()
	{
		$(this).removeClass('bac-hoveroverlay');
	}
	
	function apply_overlay(element)
	{
		/*
		 * This should be changed to create a full sized div
		 * positioned absolutely on top of the target element,
		 * with a transparent background and a fully opaque 
		 * foreground.
		 */
		overlaydiv = $("<div>");
		overlaydiv.html('Edit');
		overlaydiv.css("opacity", "1.0");
		overlaydiv.css("position", "absolute");
		overlaydiv.css("top", "0");
		overlaydiv.css("right", "0");
		element.css("position", "relative");
		element.append(overlaydiv);
		
	}
		
	function edit_click(e)
	{		
		
		//data[0] - iFrame target element
		//data[1] - editor
		console.log(e.data[1]);
		console.log(e.data[0]);
		$(this).removeClass('bac-hoveroverlay');
		
	}
	
	function find_targets()
	{	
		var editorcounter = 0;
		//For each element with bac-id
        $('#targetpage').contents().find('*[data-bac-id]').each(function(i) {
            page = $(this).closest('*[data-bac-page]').attr('data-bac-page');
            container = $(this).attr('data-bac-id');
            $(this).attr('contenteditable', 'true');
            
            //For each container, put a hidden element over top of it.
            $(this).click([this, editorcounter], edit_click);
            $(this).mouseover(editmouseover);
            $(this).mouseout(editmouseout);
            apply_overlay($(this));
            editorcounter++;
        });
	}
	
	$('#targetpage').load(function()
	{
		find_targets();
	});

});