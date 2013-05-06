<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- jQuery, Bootstrap and Google fonts -->
		<script type="text/javascript" src="jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Cuprum:400,700' rel='stylesheet' type='text/css'>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!-- Style sheet -->
		<link href="styles/framework.css" rel="stylesheet" media="screen" />
		<link href="styles/content.css" rel="stylesheet" media="screen" />
		<!-- BAC loader -->
		<script type="text/javascript" src="bac/loader.js"></script>
	</head>

	<body>
		<div class="navbar">
			<div class="navbar-inner" id="menubar">
				<ul class="nav">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li>
						<a href="bac.zip">Download</a>
					</li>
					<li>
						<a href="started.php">Getting Started</a>
					</li>
					<li>
						<a href="support.php">Documentation/Support</a>
					</li>
					<li>
						<a href="try.php">Demo</a>
					</li>
					<li>
						<a href="about.php">About</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="row title text-left title" >
				<div class="row-inner">
					Getting Started with BAC
				</div>
			</div>
			<div class="row text-left" id="steps">
				<div class="row-inner">
					<h1>Installing and Running BAC</h1>
					<ul>
						<li>
							<strong><a href="bac.zip">Download</a></strong> the zip file
						</li>
						<li>
							<strong>Unzip</strong> the bac folder, and copy it somewhere onto your web server.
							<br />
							<p class="details">
								For example, the root directory of your website.
							</p>
						</li>
						<li>
							<strong>Run</strong> the setup page, by navigating to that directory from a web browser.
							<br />
							<p class="details">In the previous example, this would be done by going to http://<i>yourwebsite.com</i>/bac</p>
						</li>
						<li>
							Follow the on-screen setup to configure an administrative password and website map.
							<br />
							<p class="details">
								By specifying an administrative password, you prevent unauthorized access to the BAC Console, 
								where you can add, delete and update content for your website. You'll also have to share the
								password with anyone else who should have access to modifiying the website.
								<br /><br />
								The sitemap is what makes BAC unique. As you define <i>pages</i> and <i>containers</i>, they
								should align roughly to your current website design. These are the categories and content
								pieces that you can fill in and make editable across your site.
								<br /><br />
								For more details about the sitemap, see <a href="support.php#sitemaps">Sitemaps</a>
							</p>
						</li>
						<li>
							Add references to your containers on your website pages
							<p class="details">
								This is as simple as adding two HTML attributes and a 
								script tag, or one line of PHP. For example, 
							</p>
								<code>
<pre>
  &lt;html&gt;
    &lt;head&gt;
      &lt;script src="bac/loader.js"&gt;&lt;/script&gt;
    &lt;/head&gt;
    &lt;body data-bac-page="Home"&gt;
      &lt;div id="myContainerDivId" data-bac-id="myBACContainerName"&gt;
      &lt;/div&gt;
    &lt;/body&gt;
  &lt;/html&gt;
</pre>
								</code>
						</li>
					</ul>						
				</div>
			</div>
			<div class="row text-left" id="faq">
				<div class="row-inner">
					<h1>Frequently Asked Questions</h1>
					<ul>
						<li>
							What are 'containers' and 'pages'?
							<p class="details">
								<strong>Containers</strong> are the atomic pieces of content that make up your website.
								For example, an introduction paragraph on a home page, or an answer to a question in an
								FAQ section would be a container. <br /><br />
								You can also make a container a piece of content you consistently reuse, like a footer,
								navigation bar or menu items.
								<br /><br />
								<strong>Pages</strong> are buckets that hold containers. You can define a page, and use 
								it as a category to hold similar containers. For example, your sitemap will usually reflect
								the actual pages of your website (Home, About, Contact Us...). However, you can also define
								other pages, like 'Common', 'Navigation' etc.
							</p>
							<br /><br />
						</li>
						<li>
							How do I add a new page? A new container?
							<br />
							<p class="details">
								After installing, go to the 'Setup' page, and edit your sitemap. For more information, check 
								<a href="support.php">the support page</a>.
							</p>
						</li>
							<br /><br />
						<li>
							How is BarelyACMS different from other Content Management Systems?

							<p class="details">
								BarelyACMS is different because it's intended to give you complete freedom in how you design
								the site. It focuses on features that will make your life easier when it comes to handling 
								content, like rich text editing.
							</p>
							<br /><br />
						</li>
						<li>
							What are the requirements for running BAC on my website?
							<br />
							<p class="details">
								BAC requires: <br />
								- PHP 5 <br />
								- About 50kb of server space <br />
								<br />
								That's it! BAC uses a flat file storage system for holding content, so there's no need for a database.
							</p>
						</li>
					</ul>						
				</div>
			</div>
		</div>	
		<div class="footer">
			BarelyACMS (c)2013 Alex Aylwin. See my other projects at <a href="http://alexaylwin.campsoc.com">my website</a> or <a href="http://github.com/alexaylwin">my Github</a>.
		</div>
	
	</body>
</html>