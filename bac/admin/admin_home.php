<?php
include 'auth.php';
include '../src/framework/classloader.php';
?>

<?php
include 'header.php'
?>
<p>
	This page is used for administrative tasks. From here, you can configure some site settings,
	edit any predefined content panel, or change the administration password.
	<br />
	To edit a page, click on 'Edit a page' from the list below.
</p>
Administrative tasks:
<ul>
	<li>
		<a href="listpages.php">Edit a page</a>
	</li>
	<li>
		<a href="settings.php">Change administrative settings</a>
	</li>
	<li>
		<a href="logout.php">Log out</a>
	</li>
</ul>

<?php
include 'footer.php'
?>