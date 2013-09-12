/**
 * TODO: figure out the jquery inclusion stuff. it needs to check for the right version and
 * use noconflict if the wrong version is found 
 *
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
function load()
{
	//Run loader.js after the DOM is completely loaded
	$(document).ready(function(){
		
		function bac_load_content(bucket, block)
		{
			ret = "a";
			$.ajax("bac/load.php",
				{	async: false,
					success: 
						function(data, status, xhr)
						{
							ret = data;		
						},
					data:{ bucket:bucket, block:block },
					dataType: "html"
				});
			return ret;
		}
		
		/*
		 * Iterates through all the data-bac-id attributes and loads the
		 * content for each one
		 */
		function bac_scan_document()
		{
			//For each element with bac-id
	        $('*[data-bac-block]').each(function(i) {
	            bucket = $(this).closest('*[data-bac-bucket]').attr('data-bac-bucket');
	            block = $(this).attr('data-bac-block');
	            content = bac_load_content(bucket, block)
	            $(this).html(content);
	        }); 
			
			
		}
		bac_scan_document(); 
	});
}

if(typeof jQuery=='undefined') {
    var headTag = document.getElementsByTagName("head")[0];
    var jq = document.createElement('script');
    jq.type = 'text/javascript';
    jq.src = 'jquery.min.js';
    jq.onload = load;
    headTag.appendChild(jq);
} else {
     load();
}
