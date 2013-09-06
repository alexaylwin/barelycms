		$(document).ready(function() {

			var parentdiv = $("#controllist");
			var addbucket = '<li class="bucketrow new"><div class="control-group"><div class="controls" style="margin-left: 0px;"><div class="input-append"><input class="newbucketbox input-medium" type="text"> <button class="btn newbucket" type="button">Add Bucket</button></div></div></div></li>';
			var addblock = '<li class="blockrow new"><div class="control-group"><div class="controls" style="margin-left: 0px;"><div class="input-append"><input class="newblockbox input-medium" type="text"><button class="btn newblock" type="button">Add Block</button></div></div></div></li>';
			var deletebutton = '<button class="btn btn-mini btn-danger delete" type="button">X</button>';
			var row = '<li></li>';
			var sitemap = $("#sitemap").val();//"page1:container1,container2|page2:container3,container4";

			//The sitemap string is delimited, and looks like:
			//page:container1,container2,container3|page:container1,container2....
			function buildSiteMapString() {
				firstbucket = true;
				firstblock = true;
				var sitemap = "";
				$("#controllist > li").each(function() {
					if ($(this).hasClass("bucketrow") && !$(this).hasClass('new')) {
						bucketname = $(this).children('span').text();
						if (firstbucket) {
							sitemap = sitemap + bucketname + ":";
						} else {
							sitemap = sitemap + "|" + bucketname + ":";
						}
						firstblock = true;
						firstbucket = false;
					} else if ($(this).hasClass("blockrow") && !$(this).hasClass('new')) {
						blockname = $(this).children('span').text();
						if (firstblock) {
							sitemap = sitemap + blockname;
						} else {
							sitemap = sitemap + "," + blockname;
						}
						firstblock = false;
					}
				});
				return sitemap;
			}
			
			function buildSiteMapList(siteMapString)
			{
				//Here we parse the sitemap string into a list tree
				var bucketstrings = siteMapString.split("|");
				var bucketname = "";
				var blocklist = "";
				var blockname = "";
				for(i = 0; i < bucketstrings.length; i++)
				{
					temp = bucketstrings[i].split(":");
					bucketname = temp[0];
					blocklist = temp[1].split(",");
					
					//here we need to get the context to pass to the addbucket method, probably the button
					ctx = $(".newbucket");
					
					var newdelete = $(deletebutton);
					var newspan = $('<span>');
					newspan.text(bucketname);	

					var newbucketrow = $(row);
					newbucketrow.addClass("bucketrow");
					newbucketrow.append(newspan);
					newbucketrow.append(newdelete);

					var newblockrow = $(addblock);

					ctx.closest('li').before(newbucketrow);
					ctx.closest('li').before(newblockrow);
				
					for(j = 0; j < blocklist.length; j++)
					{
						blockname = blocklist[j];
						if(blockname.length > 0)
						{
						ctx = $('.newblock:last');
						
						var newdelete = $(deletebutton);

						var newspan = $('<span>');
						newspan.text(blockname);

						var newblockrow = $(row);
						newblockrow.addClass("blockrow");
						newblockrow.append(newspan);
						newblockrow.append(newdelete);

						ctx.closest('li').before(newblockrow);
						}
					}
				}
				
				
				
			}

			function doScroll() {
				$('html, body').animate({
					scrollTop : $(document).height()
				}, 0);
			}

			function addBucket(ctx) {
				var newdelete = $(deletebutton);
				var bucketname = $('.newbucketbox').val();
				if (bucketname == "") {
					ctx.closest('.control-group').addClass('error');
					return;
				}
				var newspan = $('<span>');
				newspan.text(bucketname);

				var newbucketrow = $(row);
				newbucketrow.addClass("bucketrow");
				newbucketrow.append(newspan);
				newbucketrow.append(newdelete);

				var newblockrow = $(addblock);

				ctx.closest('li').before(newbucketrow);
				ctx.closest('li').before(newblockrow);
				ctx.closest('.control-group').removeClass('error');
			}

			function addBlock(ctx) {
				var newdelete = $(deletebutton);
				var blockname = $(".newblockbox", ctx.parent()).val();

				if (blockname == "") {
					ctx.closest('.control-group').addClass('error');
					return;
				} 
				
				
				
				var newspan = $('<span>');
				newspan.text(blockname);

				var newblockrow = $(row);
				newblockrow.addClass("blockrow");
				newblockrow.append(newspan);
				newblockrow.append(newdelete);

				ctx.closest('li').before(newblockrow);
				ctx.closest('.control-group').removeClass('error');

			}

			function deleteRow(ctx) {
				var parentrow = ctx.closest('li');

				if (parentrow.hasClass("bucketrow")) {
					//Loop get each row below this one, until we find a bucketrow
					crow = null;
					crow = parentrow.next();
					while (!crow.hasClass("bucketrow")) {
						crow.remove();
						crow = parentrow.next();
					}

					parentrow.remove();
				} else if (parentrow.hasClass("blockrow")) {
					parentrow.remove();
				}

			}


			$(parentdiv).on("keydown", '.newblockbox', function(event) {
				if ((event.which == 13 || event.keyCode == 13)) {
					event.preventDefault();
					$(this).focus();
					$(this).next().click();
				}
			});

			$(parentdiv).on("keydown", '.newbucketbox', function(event) {
				if ((event.which == 13 || event.keyCode == 13)) {
					event.preventDefault();
					$(this).focus();
					$(this).next().click();
				}
			});

			$(parentdiv).on("click", ".newbucket", function(event) {
				var ctx = $(this);
				addBucket(ctx);
				$(this).prev().val("");
				doScroll();
			});

			$(parentdiv).on("click", ".newblock", function(event) {
				var ctx = $(this);
				addBlock(ctx);
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

			parentdiv.append($(addbucket));
			buildSiteMapList(sitemap);
		});