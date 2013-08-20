<?php include 'header.php' ?>
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
<?php include 'footer.php' ?>	</body>
</html>