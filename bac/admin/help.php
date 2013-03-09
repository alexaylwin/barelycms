<?php
include 'auth.php';
include '../src/framework/classloader.php';
?>

<?php
include 'header.php'
?>
<p>
	<h4>BarelyACMS Support</h4>
	<p>
		BarelyACMS is a <strong>content</strong> management system, that gives you an unobtrusive way to manage your web content, without
		it getting in the way of your web design. <br /> <br />
		
		<h5>Getting started</h5>
		To get started, you can go to the <a href="pages.php">Pages page</a> and enter some container content. Then you can include your content anywhere
		on your website by making a call to <i>/bac/load.php?page=pagename&amp;container=containername</i>. In the examples below, there is a page called 'index'
		and a container called 'mainbody' on the index page. 
		<dl class="dl-horizontal">
			<dt>jQuery Ajax:</dt>
			<dd>
			<pre style="width:400px;">
$(document).ready(function() {
  $.get(  
    "bac/load.php", 
    {page:"index", container:"mainbody"}, 
    function(data){
        $('#content').html(data);
    });
});
			</pre>
			</dd>
			<dt>PHP:</dt>
			<dd>
				<pre style="width:400px;">
&lt;?php
  include('/bac/load_container.php');
  echo load_container('index', 'mainbody');
?&gt;
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
					BarelyACMS doesn't create website pages for you. Instead, it lets you create virtual 'pages' that serve as boxes to put 'containers' on.
					These pages are defined on the <a href="setup.php">setup page</a>, in the sitemap section. A container is how BAC organizes its content. You can think of a container as one 'piece' of content, that you can include anywhere on
					your website. For example, if you have a page 'Contact Us' then you might have the containers 'Address and Phone Number', 'About', 'Map' and so on.
					</p>
					<p>
					On your website, you would reference these containers using javascript and include the content inside your design, however you want.
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
					To edit a container, go to the <a href="pages.php">Pages page</a> and select a container to edit. You can update and save the container
					using the WYSIWYG editor (or HTML). If you want to define a new page or a new container, go to the <a href="setup.php">setup page</a> and edit
					your site map.
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help2"> How do I create a new page? </a>
			</div>
			<div id="help2" class="accordion-body collapse">
				<div class="accordion-inner">
					You can create a new page by going to the <a href="setup.php">setup page</a> and using the sitemap.
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help3"> Who made BarelyACMS? </a>
			</div>
			<div id="help3" class="accordion-body collapse">
				<div class="accordion-inner">
					BarelyACMS was made by Alex Aylwin, a recent graduate of McMaster University in Software Engineering. You can get a hold of him on <a href="http://www.twitter.com/alexaylwin">Twitter</a> or <a href="http://alexaylwin.campsoc.com">his website.</a>
				</div>
			</div>
		</div>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#helpaccordion" href="#help4"> Where can I go for more support? </a>
			</div>
			<div id="help4" class="accordion-body collapse">
				<div class="accordion-inner">
					If you'd like more support, you can check out the github repository at <a href="http://github.com/alexaylwin/barelycms">http://github.com/alexaylwin/barelycms</a> for documentation.
					<br />
					Or feel free to email me (Alex!) at <a href="#">alexaylwin@gmail.com</a>
				</div>
			</div>
		</div>
	</div>
</p>
<?php
include 'footer.php'
?>
