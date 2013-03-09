		$(document).ready(function() {

			var parentdiv = $("#controllist");
			var addpage = '<li class="pagerow new"><div class="control-group"><div class="controls" style="margin-left: 0px;"><div class="input-append"><input class="newpagebox input-medium" type="text"> <button class="btn newpage" type="button">Add Page</button></div></div></div></li>';
			var addcontainer = '<li class="containerrow new"><div class="control-group"><div class="controls" style="margin-left: 0px;"><div class="input-append"><input class="newcontainerbox input-medium" type="text"><button class="btn newcontainer" type="button">Add Container</button></div></div></div></li>';
			var deletebutton = '<button class="btn btn-mini btn-danger delete" type="button">X</button>';
			var row = '<li></li>';
			var sitemap = $("#sitemap").val();//"page1:container1,container2|page2:container3,container4";

			//The sitemap string is delimited, and looks like:
			//page:container1,container2,container3|page:container1,container2....
			function buildSiteMapString() {
				firstpage = true;
				firstcontainer = true;
				var sitemap = "";
				$("#controllist > li").each(function() {
					if ($(this).hasClass("pagerow") && !$(this).hasClass('new')) {
						pagename = $(this).children('span').text();
						if (firstpage) {
							sitemap = sitemap + pagename + ":";
						} else {
							sitemap = sitemap + "|" + pagename + ":";
						}
						firstcontainer = true;
						firstpage = false;
					} else if ($(this).hasClass("containerrow") && !$(this).hasClass('new')) {
						containername = $(this).children('span').text();
						if (firstcontainer) {
							sitemap = sitemap + containername;
						} else {
							sitemap = sitemap + "," + containername;
						}
						firstcontainer = false;
					}
				});
				return sitemap;
			}
			
			function buildSiteMapList(siteMapString)
			{
				//Here we parse the sitemap string into a list tree
				var pagestrings = siteMapString.split("|");
				var pagename = "";
				var containerlist = "";
				var containername = "";
				for(i = 0; i < pagestrings.length; i++)
				{
					temp = pagestrings[i].split(":");
					pagename = temp[0];
					containerlist = temp[1].split(",");
					
					//here we need to get the context to pass to the addpage method, probably the button
					ctx = $(".newpage");
					
					var newdelete = $(deletebutton);
					var newspan = $('<span>');
					newspan.text(pagename);	

					var newpagerow = $(row);
					newpagerow.addClass("pagerow");
					newpagerow.append(newspan);
					newpagerow.append(newdelete);

					var newcontainerrow = $(addcontainer);

					ctx.closest('li').before(newpagerow);
					ctx.closest('li').before(newcontainerrow);
				
					for(j = 0; j < containerlist.length; j++)
					{
						containername = containerlist[j];
						if(containername.length > 0)
						{
						ctx = $('.newcontainer:last');
						
						var newdelete = $(deletebutton);

						var newspan = $('<span>');
						newspan.text(containername);

						var newcontainerrow = $(row);
						newcontainerrow.addClass("containerrow");
						newcontainerrow.append(newspan);
						newcontainerrow.append(newdelete);

						ctx.closest('li').before(newcontainerrow);
						}
					}
				}
				
				
				
			}

			function doScroll() {
				$('html, body').animate({
					scrollTop : $(document).height()
				}, 0);
			}

			function addPage(ctx) {
				var newdelete = $(deletebutton);
				var pagename = $('.newpagebox').val();
				if (pagename == "") {
					ctx.closest('.control-group').addClass('error');
					return;
				}
				var newspan = $('<span>');
				newspan.text(pagename);

				var newpagerow = $(row);
				newpagerow.addClass("pagerow");
				newpagerow.append(newspan);
				newpagerow.append(newdelete);

				var newcontainerrow = $(addcontainer);

				ctx.closest('li').before(newpagerow);
				ctx.closest('li').before(newcontainerrow);
				ctx.closest('.control-group').removeClass('error');
			}

			function addContainer(ctx) {
				var newdelete = $(deletebutton);
				var containername = $(".newcontainerbox", ctx.parent()).val();

				if (containername == "") {
					ctx.closest('.control-group').addClass('error');
					return;
				} 
				
				
				
				var newspan = $('<span>');
				newspan.text(containername);

				var newcontainerrow = $(row);
				newcontainerrow.addClass("containerrow");
				newcontainerrow.append(newspan);
				newcontainerrow.append(newdelete);

				ctx.closest('li').before(newcontainerrow);
				ctx.closest('.control-group').removeClass('error');

			}

			function deleteRow(ctx) {
				var parentrow = ctx.closest('li');

				if (parentrow.hasClass("pagerow")) {
					//Loop get each row below this one, until we find a pagerow
					crow = null;
					crow = parentrow.next();
					while (!crow.hasClass("pagerow")) {
						crow.remove();
						crow = parentrow.next();
					}

					parentrow.remove();
				} else if (parentrow.hasClass("containerrow")) {
					parentrow.remove();
				}

			}


			$(parentdiv).on("keydown", '.newcontainerbox', function(event) {
				if ((event.which == 13 || event.keyCode == 13)) {
					event.preventDefault();
					$(this).focus();
					$(this).next().click();
				}
			});

			$(parentdiv).on("keydown", '.newpagebox', function(event) {
				if ((event.which == 13 || event.keyCode == 13)) {
					event.preventDefault();
					$(this).focus();
					$(this).next().click();
				}
			});

			$(parentdiv).on("click", ".newpage", function(event) {
				var ctx = $(this);
				addPage(ctx);
				$(this).prev().val("");
				doScroll();
			});

			$(parentdiv).on("click", ".newcontainer", function(event) {
				var ctx = $(this);
				addContainer(ctx);
				$(this).prev().val("");
				doScroll();
			});

			$(parentdiv).on("click", ".delete", function(event) {
				var ctx = $(this);
				deleteRow(ctx);
			});

			$("#save").click(function() {
				$('#sitemap').val(buildSiteMapString());
			});
			
			$("#continue").click(function(){
				$("#setupform").submit();
			});

			parentdiv.append($(addpage));
			buildSiteMapList(sitemap);
		});