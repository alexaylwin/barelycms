/**
 *	loader.js
 * 
 * This javascript file provides ajax-enabled loading of BAC content onto any HTML page
 * that uses the data-bac-id and data-bac-page attributes. The following snippet shows
 * an example of using loader.js in an HTML page:
 * 
 * <html>
 * <head>
 * <script src="bac/loader.js"></script>
 * ...
 * <body data-bac-page="index">
 * ...
 * <div id="my_dynamic_div" data-bac-id="intro"></div>
 * ...
 * </html>
 * 
 * The loader.js file runs after the DOM is fully loaded, and fills the inner hmtl of any
 * element with the data-bac-id attribute. It decides on the page based on the closest 
 * data-bac-page, and uses ajax to query the load.php script.
 */

//Run loader.js after the DOM is completely loaded
$(document).ready(function(){
	
	function load_content(page, container)
	{
/*
		$.get(	"bac/load.php", { page:page, container:container })
			.success(
				function(data, status, xhr)
				{
					alert(data);
					return data;
				}
		);
*/
		ret = "a";
		$.ajax("bac/load.php",
			{	async: false,
				success: 
					function(data, status, xhr)
					{
						ret = data;		
					},
				data:{ page:page, container:container },
				dataType: "html"
			});
		return ret;		

	}
	
	/*
	 * Iterates through all the data-bac-id attributes and loads the
	 * content for each one
	 */
	function scan_document()
	{
		//For each element with bac-id
        $('*[data-bac-id]').each(function(i) {
            page = $(this).closest('*[data-bac-page]').attr('data-bac-page');
            container = $(this).attr('data-bac-id');
            content = load_content(page, container)
            $(this).html(content);
        }); 
		
		
	}

	scan_document();
	
});

