/**
 *liveedit.js
 * 
 * This javascript file is responsible for enabling the in-page (WYSIWYG) editing features
 * of BAC. It uses the inline CKEditor (http://ckeditor.com/) for it's rich text editing
 * toolbar. 
 * 
 * The script runs on page load, attaching an event to the iframe load. After the iframe is
 * loaded, it scans the document for any BAC pages and containers, adding a 'contenteditable' 
 * HTML5 attribute, and attaching some mouseover events to visually show that editing is allowed
 * on that element.
 * 
 * CKEditor is used to format text, and a handler is attached to the CKEditor save functionality,
 * AJAX is used to post data back to liveedit.php.
 */

$(document).ready(function()
{	
	
	var editors = [];
	
	//TODO: this function is responsible for displaying the edit overlay
	//when the user hovers on an element. Currently, the mouseover event
	//is firing multiple times whent the user moves the mouse over the
	//target. This could be a jQuery bug, or related to the changing
	//HTML in the target element (which triggers another mousemove). More
	//investigation is required to stop the flicker.	
	function editmouseover(e)
	{
		console.log($(this).attr('id') + ' MOUSEOVER');
		//Move the overlay div to directly on top of the current div,
		//redimension it to match this div's dimensions, and show it.
		//$(this).addClass('bac-hoveroverlay');
		 var mouseover = $('#bac-mouseover');
		 mouseover.css('display', 'block').css('position', 'absolute');
		// mouseover.css($(this).offset());
		
		console.log('scrollTop: ' + $('#bac-targetpage').contents().scrollTop());
		mouseover.position({
			my: 'left top-'+$('#bac-targetpage').contents().scrollTop(),
			at: 'left top',
			of: $(this),
			collision: 'none'
		});
		 mouseover.width($(this).outerWidth());
		 mouseover.height($(this).outerHeight());
		 console.log("target: (" + $(this).position().top + "," + $(this).position().left + ")");
		 console.log("over: (" + mouseover.position().top + "," + mouseover.position().left + ")");
		 e.stopPropagation();
		
	}
	
	function editmouseclick(e)
	{
		mouseover = $('#bac-mouseover');
		//mouseover.css('display', 'none');		
		//e.stopPropagation();
	}
	
	function editmouseout(e)
	{
		mouseover = $('#bac-mouseover');
		mouseover.css('display', 'none');
		e.stopPropagation();
	}
	
	function apply_overlay(element)
	{
		/*
		 * This should be changed to create a full sized div
		 * positioned absolutely on top of the target element,
		 * with a transparent background and a fully opaque 
		 * foreground.
		 */
		overlaydiv = $('<div>');
		overlaydiv.html('Edit');
		overlaydiv.css('opacity', '1.0');
		overlaydiv.css('position', 'absolute');
		overlaydiv.css('top', '0');
		overlaydiv.css('right', '0');
		element.css('position', 'relative');
		element.append(overlaydiv);
		overlaydiv.attr('contenteditable', 'false');
		
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
        $('#bac-targetpage').contents().find('*[data-bac-id]').each(function(i) {
            page = $(this).closest('*[data-bac-page]').attr('data-bac-page');
            container = $(this).attr('data-bac-id');
            $(this).attr('contenteditable', 'true');
            
            //For each container, put a hidden element over top of it.
           // $(this).click(editmouseclick);//[this, editorcounter], edit_click);
           // $(this).mouseenter(editmouseover);
           // $(this).mouseleave(editmouseout);
           // apply_overlay($(this));
            editorcounter++;
            
            var e = CKEDITOR.inline(this, {customConfig: 'config_liveedit.js'});
            var ed = {containerid: container, pageid: page, editorid: e.id};
            editors.push(ed);
        });
	}
	
	$('#bac-targetpage').load(function()
	{
		find_targets();
	});
	
	// Override the normal CKEditor save plugin
	CKEDITOR.plugins.registered['save'] =
	{
	    init : function( editor )
	    {
	        editor.addCommand( 'save', 
	            {
	                modes : { wysiwyg:1, source:1 },
	                exec : function( editor ) {
	                	var page = '';
	                	var container = '';
	                	for(i = 0; i < editors.length; i++)
	                	{
	                		if(editors[i].editorid == editor.id)
	                		{
	                			page = editors[i].pageid;
	                			container = editors[i].containerid;
	                		}
	                	}
	                	
						$.ajax({
							type: "POST",
							url: "liveedit.php",
							data: {	'containercontent':editor.getData(),
									'containerid':container,
									'pageid':page
								  }
						}).done(function(data){
							if(data == '1')
							{
								alert('Container Saved!');
							}
						});
	                }
	            }
	        );
	        editor.ui.addButton( 'Save', {label : 'Save', command : 'save', icon : 'images/save.png'} );
	    }
	}

});