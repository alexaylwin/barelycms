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
	
	window.editors = [];
	
	//TODO: this function is responsible for displaying the edit overlay
	//when the user hovers on an element. Currently, the mouseover event
	//is firing multiple times whent the user moves the mouse over the
	//target. This could be a jQuery bug, or related to the changing
	//HTML in the target element (which triggers another mousemove). More
	//investigation is required to stop the flicker.	
	function editmouseover(e)
	{
		//Move the overlay div to directly on top of the current div,
		//redimension it to match this div's dimensions, and show it.
		//$(this).addClass('bac-hoveroverlay');
		 var mouseover = $('#bac-mouseover');
		 mouseover.css('display', 'block').css('position', 'absolute');
		// mouseover.css($(this).offset());
		
		mouseover.position({
			my: 'left top-'+$('#bac-targetpage').contents().scrollTop(),
			at: 'left top',
			of: $(this),
			collision: 'none'
		});
		 mouseover.width($(this).outerWidth());
		 mouseover.height($(this).outerHeight());
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
		$(this).removeClass('bac-hoveroverlay');
		
	}
	
	function find_targets()
	{	
		var editorcounter = 0;
		//For each element with bac-id
        $('#bac-targetpage').contents().find('*[data-bac-block]').each(function(i) {
			//inline editing only works for elements with an ID
			if(typeof $(this).attr('id') == 'undefined')
			{
				var id = $(this).closest('*[data-bac-bucket]').attr('data-bac-bucket') + "-" + $(this).attr('data-bac-block');
				$(this).attr('id', id)
			}
			
			if(typeof $(this).attr('id') !== 'undefined')
			{
				bucket = $(this).closest('*[data-bac-bucket]').attr('data-bac-bucket');
				block = $(this).attr('data-bac-block');
				$(this).attr('contenteditable', 'true');
				
				//For each container, put a hidden element over top of it.
				//$(this).click(editmouseclick);//[this, editorcounter], edit_click);
			   // $(this).mouseenter(editmouseover);
			   // $(this).mouseleave(editmouseout);
			   // apply_overlay($(this));
				editorcounter++;
				var e = CKEDITOR.inline($(this).get(0), {customConfig: 'config_liveedit.js'});
				var name = e.name;
				var ed = {blockid: block, bucketid: bucket, editorid: e.id};
				editors.push(ed);
			}
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
	                	var bucket = '';
	                	var block = '';
	                	for(i = 0; i < editors.length; i++)
	                	{
	                		if(editors[i].editorid == editor.id)
	                		{
	                			bucket = editors[i].bucketid;
	                			block = editors[i].blockid;
	                		}
	                	}
						$.ajax({
							type: "POST",
							url: "liveedit.php",
							data: {	'blockcontent':editor.getData(),
									'blockid':block,
									'bucketid':bucket
								  }
						}).done(function(data){
							if(data == '1')
							{
								alert('Content saved!');
							} else {
								alert('There was an error, couldn\'t save!');
							}
						});
	                }
	            }
	        );
	        editor.ui.addButton( 'Save', {label : 'Save', command : 'save', icon : 'images/save.png'} );
	    }
	}

});