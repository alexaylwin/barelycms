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
					Documentation and Support
				</div>
			</div>
			<div class="row text-left" id="support">
				<div class="row-inner">
					<h1>Support</h1>
					<p>
						For support, please reference the topics below. If you can't find the answer to 
						an issue you're having, please drop me an email at: AlexAylwin@gmail.com
					</p>
					<br />
					<ul>
						<li>
							<strong>Configuring your BAC Installation</strong> 
							<p class="details">
								BAC uses paths relative to its own installation directory to operate. All 
								the content of the CMS is stored in the bac/container_content directory.
								No manual configuration should be needed to get BAC up and running, other
								than copying and pasting the entire bac folder into your root directory.
								<br /> <br />
								For example at the company AbcInc.com, they have the following file structure
								on their website: 
							</p>
							<div style="font-family:monospace; width:300px; margin-right:auto; margin-left:auto;">
								. <br />
								.. <br />
								aboutus.html <br />
								bac <br />
								bootstrap <br />
								home.html <br />
								scripts.js <br />
								site_styles.css <br />
							</div>
							<p class="details">
								To access the BAC console, the administrators can just access http://www.abcinc.com/bac. 
								This will take them to the login page. You can move the folder to wherever you want
								in your file structure, but it's recommended that you place it in the root directory.
								<br /> <br />
								There are no user configurable files in the BAC directory, except for the content
								files, which you can safely edit directly, if you like. 
							</p>
						</li>
						<br /> <br />
						<li><a name="sitemaps" />
							<strong>About your sitemap</strong>
							<p class="details">
								The sitemap is what BAC uses to create a logical view of your content. Please note that
								the 'sitemap' doesn't <i>have</i> to corrospond directly to your actual website
								pages! You can use the 'pages' of the sitemap to create other boxes where you hold
								pieces of content. For example, a sitemap might be:
							</p>
							<pre style="font-size:14px; line-height: 14px; margin-left:20px;">
- Index
	- About Us
	- Intro
	- Download Now
- Contact
	- Directions
	- Map
- About Us
	- Founding
	- Who Are We
- Header
	- Header
	- Navigation Bar
- Footer
	- Footer				
							</pre>
							<p class="details">
								In this example, there are three website pages defined in the CMS: Index, Contact and About Us.
								These pages have a few containers each, that hold different sections of the 
								website. The last two pages, Header and Footer are not actual pages of content on
								the website. They are common content used across all pages. But, with BAC you can
								define content and place it anywhere. The administrator has used BAC to create a 
								custom template, so that they can easily update the navigation bar (For example, if they
								want to add a new page later on.)
							</p>
						</li>
						<br /> <br />
						<li>
							<strong>Managing your sitemap</strong>
							<p class="details">
								You can manage your sitemap by clicking on the 'Setup' button on the navigation
								bar. Scroll to the bottom of the page, and you'll see the sitemap section. To
								add a new page, enter the desired page name in the bottom text-box and click 
								enter. The page will automatically be added at the bottom of the list. To add
								a container, enter the container name under the page and press enter. To delete
								a page or container, click the red 'X' beside the name. Click 'Save' at the bottom
								of the page to save your changes. 
							</p>
						</li>
						<br /><br />
						<li>
							<strong>Editing a Container</strong>
							<p class="details">
								To add content to a container, click on the 'Pages' button on the navigation bar. 
								Click on the container on the page that you would like to edit, and use the rich
								text editor to create content. Click on the 'Save' button to save your changes, and
								they will be instantly reflected on your live website.
								
								
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