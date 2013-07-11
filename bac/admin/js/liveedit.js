$(document).ready(function()
{	
	var editors = [];
	
	function create_editor(page, container)
	{
		console.log(page + "-" + container);
		editor = $('<div class="liveeditor_container"><textarea id="liveeditor-'+page+'-'+container+'" name="liveeditor" class="tinymce liveeditor"></textarea></div>');
		// editor.attr('style', $(this).attr('style'));
		
		editor.copyCSS($(this));
		editor.find('#liveeditor').width($(this).width());
		editor.find('#liveeditor').height($(this).height());
						
		editors.push(editor);
		
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
	
	function editclick(e)
	{
		// for(i = 0; i < editors.length; i++)
		// {
			// editor = editors[i];
			// if(editor.find)
		// }
		
		editor = editors[e.data[1]];
		console.log(editor);
		console.log(e.data[0]);
		$(e.data[0]).replaceWith(editor);
		
		editor.tinymce({
			// Location of TinyMCE script
			script_url : window.bac_jspath + '/tiny_mce/tiny_mce.js"',

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
			content_css : "../admin/styles/editor_styles.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js"

		});

	}
	
	function find_targets()
	{	
		var editorcounter = 0;
		//For each element with bac-id
        $('#targetpage').contents().find('*[data-bac-id]').each(function(i) {
            page = $(this).closest('*[data-bac-page]').attr('data-bac-page');
            container = $(this).attr('data-bac-id');
            
            //For each container, put a hidden element over top of it.
            create_editor(page, container);
            $(this).click([this, editorcounter], editclick);
            $(this).mouseover(editmouseover);
            $(this).mouseout(editmouseout);
            apply_overlay($(this));
        });
	}
	
	$('#targetpage').load(function()
	{
		find_targets();
	});

});