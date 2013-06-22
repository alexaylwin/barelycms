$(document).ready(function()
{	
	/*
	 * handle the click event on an editable container
	 * do the following:
	 * 	- load the tinymce control
	 * 	- query the load script for the correct html
	 * 	- send a successful edit from tinymce to liveedit_process via ajax
	 * 		(this does a page write)
	 * 	- get the iframe to call an update on its content
	 * 	- delete the tinymce control
	 */
	function editclick()
	{
		editor = $('<div id="liveeditor_container"><textarea id="liveeditor" name="liveeditor" class="tinymce liveeditor"></textarea></div>');
		editor.find('#liveeditor').width($(this).width());
		editor.find('#liveeditor').height($(this).height());
		editor.attr('style', $(this).attr('style'));

		$(this).replaceWith(editor);
		//$(this).before('<textarea id="liveeditor" name="liveeditor" class="tinymce liveeditor"></textarea>');
		
		// editor = $(this).parent().find('#liveeditor');
		// editor.css('top', $(this).position().top);
		// editor.css('left', $(this).position().left);

		//$(this).css('display', 'none');
		//editor.css('position', 'absolute');
		
		
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : window.bac_jspath + 'tiny_mce/tiny_mce.js',

			setup : function(ed) {
				ed.onSaveContent.add(function(ed, o) {
				});
			},
			
			//height : "300px",

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
			//content_css : "../admin/styles/editor_styles.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js"

		});
		
	}
	
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
		overlaydiv = $("<div>");
		overlaydiv.html('Edit');
		overlaydiv.css("opacity", "1.0");
		overlaydiv.css("position", "absolute");
		overlaydiv.css("top", "0");
		overlaydiv.css("right", "0");
		element.css("position", "relative");
		element.append(overlaydiv);
		
	}
	function find_targets()
	{	
		//For each element with bac-id
		console.log('entering each');
		console.log($('[data-bac-id]'));
        $('#targetpage').contents().find('*[data-bac-id]').each(function(i) {
        	console.log('each');
            page = $(this).closest('*[data-bac-page]').attr('data-bac-page');
            container = $(this).attr('data-bac-id');
            apply_overlay($(this));
            
            $(this).click(editclick);
            $(this).mouseover(editmouseover);
            $(this).mouseout(editmouseout);
        });
        console.log('exiting each');
	}
	
	$('#targetpage').load(function()
	{
		find_targets();
	});

});