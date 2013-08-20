<?php
$p = 'index'; 
include 'header.php'
?>
		<div class="container" data-bac-page="index">
			<div class="row title text-right">
				<div class="row-inner">
					<div id="title1">BarelyACMS</div>
					<div id="title2">Do one thing. <br /> Manage. Content.</div>
				</div>
			</div>
			<div class="row" id="flavor">
				<div class="row-inner">
					<div id="flavor1">
						BarelyACMS makes two promises. It will manage the #$%! out of your content.
						<br>
						<strong>And it won't get in the way.</strong>
					</div>
					<div id="flavor2">
							It won't hold your hand. It won't integrate your social media or give you prebuilt themes or templates.
					</div>
				</div>
			</div>
			<div class="row" id="freedom">
				<div class="row-inner">
					What BarelyACMS gives you is
					<div id="freedom1">Template Freedom</div>
					<div id="freedom2">
						Your content management system shouldn't be making design decisions.
						<br />
						Seriously. One line of CSS to accomodate your CMS <strong>is too much.</strong>
					</div>
				</div>
			</div>
			<div class="row" id="principles">
				<div class="row-inner">
					<div id="principles1">
						BarelyACMS is a pure content management system that is built on these
						simple principles:
					</div>
					<div class="principle-container principle-left">
						<div class="principle-title">
							Lightweight
						</div>
						<img class="principle-image" src="static/img/fill.png">
							
						</img>
						<div class="principle-caption">
							Database free, flexible and trivial to install
						</div>
					</div>
					
					<div class="principle-container principle-right">
						<div class="principle-title">
							Template-Free
						</div>
						<img class="principle-image" src="static/img/fill.png">
							
						</img>
						<div class="principle-caption">
							Use any markup you want to design your site, then include content management as an afterthought.
						</div>
					</div>
				</div>
				<div class="row-inner">
					<div class="principle-container principle-left">
						<div class="principle-title">
							Thin Client
						</div>
						<img class="principle-image" src="static/img/fill.png">
							
						</img>
						<div class="principle-caption">
							Make any element on a page editable with one attribute, an AJAX call or a single line of PHP.
						</div>
					</div>
					<div class="principle-container principle-right">
						<div class="principle-title">
							Content Focused
						</div>
						<img class="principle-image" src="static/img/fill.png">
							
						</img>
						<div class="principle-caption">
							Features like content versioning and rich text editing help with managing content, not forcing a presentation
						</div>
					</div>

				</div>
			</div>
			<div class="row" id="get">
				<div class="row-inner">
					Interested? <br /> <br />
					<button id="download" onclick="window.location='download.php'">Download it now</button>
					<button id="demo" onclick="window.location='try.php'">Try a demo</button>
				</div>
			</div>

		</div>
		<?php include 'footer.php'?>
	</body>
</html>