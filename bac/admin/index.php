<?php
include 'auth.php';
include '../src/framework/classloader.php';
?>

<?php
include 'header.php'
?>
<h4>
	Admin Home
</h4>
<p>
	Welcome back to your BAC Administration panel. From here, you can edit your sitemap, update your block content or change
	other administrative settings.
	<br />
</p>
Administrative tasks:
<ul class="unstyled">
	<li>
		<a href="buckets.php">View buckets</a>
	</li>
	<li>
		<a href="setup.php">Change administrative settings or edit site map</a>
	</li>
	<li>
		<a href="logout.php">Log out</a>
	</li>
</ul>

<?php
include 'footer.php'
?>