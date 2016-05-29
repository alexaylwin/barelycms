<?php
include 'auth.php';
include '../src/framework/classloader.php';
?>

<?php
$BAC_TITLE_TEXT = "BarelyACMS - Help";
include 'header.php'
?>
<div class="col-xs-10">
<p>
	<h4>BarelyACMS Support</h4>
	<p>
		BarelyACMS is a <strong>content</strong> management system, that gives you an unobtrusive way to manage your web content, without
		it getting in the way of your web design. <br /> <br />
		
		<h5>Getting started</h5>
		To get started, you can go to the <a href="buckets.php">Buckets page</a> and enter some block content.
		These blocks are used across your site to include the content that you've added. On any page that has
		a reference to the BAC javascript file, an HTML element that has a bucket and block attribute will be
		filled with the content you enter here. (Any content that you entered on the page by hand will be replaced.)
		<br /><br />
		For example, the following is the HTML code of a page that uses the 'About' block, in the 'Home' bucket.
		This is used on the index (home) page of a website.
		<dl class="dl-horizontal">
			<dt>index.html</dt>
			<dd>
			<pre style="width:400px;">
&lt;script src="bac/loader.js" type="javascript"&gt;&lt;/script&gt;
&lt;div bac-data-bucket="Home" bac-data-block="About"&gt;
&lt;/div&gt;
			</pre>
			</dd>
		</dl>
	</p>
	<div class="accordion" id="helpaccordion">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help0"> Where are my pages?</a>
			</div>
			<div id="help0" class="accordion-body collapse">
				<div class="accordion-inner">
					<p>
					BarelyACMS doesn't create website pages for you. Instead, it lets you create virtual pages called buckets to put blocks in.
					These buckets are defined on the <a href="settings.php">Settings page</a>, in the sitemap section. A block is how BAC organizes your content. 
					You can think of a block as one 'piece' of content, that you can include anywhere on your website. 
					For example, if you have a bucket 'Contact Us' then you might have the blocks 'Address and Phone Number', 'About', 'Map' and so on.
					</p>
					<p>
					On your website, you would reference these blocks using HTML attributes and include the content inside your design however you want.
					</p>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help1"> How do I change my content?</a>
			</div>
			<div id="help1" class="accordion-body collapse">
				<div class="accordion-inner">
					To edit a block, go to the <a href="buckets.php">Buckets page</a> and select a block to edit. You can update and save the block
					using the WYSIWYG editor (or HTML). If you want to define a new bucket or a new block, go to the <a href="settings.php">settings page</a> and edit
					your site map.
					<br /><br />
					You can also use the live editor to edit a block on your real website page. Go to the <a href="buckets.php">Buckets page</a> and
					click the live edit icon to be taken to a copy of your webpage. Any changes you make on the page will be reflected as soon as you
					save them!
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help2"> How do I create a new bucket? </a>
			</div>
			<div id="help2" class="accordion-body collapse">
				<div class="accordion-inner">
					You can create a new bucket by going to the <a href="settings.php">settings page</a> and using the sitemap.
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help4"> Where can I go for more support? </a>
			</div>
			<div id="help4" class="accordion-body collapse">
				<div class="accordion-inner">
					Check out <a href="http://bacms.ca">http://bacms.ca</a> for more documentation, support and updates.
				</div>
			</div>
		</div>
	</div>
</p>
</div>
<?php
include 'footer.php'
?>
