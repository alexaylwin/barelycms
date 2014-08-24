<?php
/**
 * This is the settings page for BAC. It allows authorized users to
 * modify BAC settings such as the sitemap, passwords and permissions.
 */

?>
<?php
include 'auth.php';
include_once ('../src/util.php');
require __DIR__ . '/handlers/SettingsHandler.php';
$requestHandler = new SettingsHandler();

$data = $requestHandler->handleRequest($_POST, $_GET);

//TODO: Remove this hack, we now use the setup.php script
$data['notfirst'] = 'true';

if(isset($data['redirectToLogin']) && $data['redirectToLogin'] == 'true')
{
	header("Location: " . get_absolute_uri("login.php"));
	die();
}

$displaymessage = "";
if(!isset($data['message'])){$data['message'] = "";}
if($data['message'])
{
	$displaymessage = "block";
} else {
	$displaymessage = "none";
}


$messageclass = 'alert-success';
if(isset($data['settingsSaved']))
{
	if($data['settingsSaved'] == 'true')
	{
		$messageclass = "alert-success";
	} else {
		$messageclass = "alert-error";
	}
}


$BAC_TITLE_TEXT = "BarelyACMS - Settings";
include 'header.php';	
?>
	<script type="text/javascript" src="js/setupform.js"></script>	
					<p>
						<h4>Setup</h4>
						<div class="alert <?php echo $messageclass; ?>" style="display:<?php echo $displaymessage; ?>;
"><?php echo $data['message']; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
						To set up BAC, set up an administrative password and then define your sitemap.
					</p>
					
					<form method="post" class="form-horizontal" id="setupform">
<!-- ADMIN PASSWORD -->
					<?php
					if($GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('changeAdminPassword') > 0)
					{
					?>
						<h6>Admin Account</h6>
						<p>
							Define the administrative password that you'll use to
							access the BAC admin panel.
						</p>
						<div class="control-group">
							<label class="control-label" for"username">Username</label>
							<div class="controls">
								<p style="display:inline-block; margin-bottom:0; margin-top: 1px;vertical-align:middle;font-size:14px;height:20px;line-height:20px;padding:4px 6px;"><strong>admin</strong></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="adminPassword">Password</label>
							<div class="controls">
								<input type="password" name="adminPassword" id="adminPassword">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="adminPasswordConfirm">Confirm password</label>
							<div class="controls">
								<input type="password" name="adminPasswordConfirm" id="adminPasswordConfirm">
							</div>
						</div>
					<?
					}
					?>
						
<!-- AUTHOR PASSWORD -->
					<?php
					if($GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('changeAuthorPassword') > 0)
					{
					?>
						
						<h6>Author Account</h6>
						<p>
							The author account is a user who is able to alter content and add blog posts,
							but cannot add or delete buckets or blocks themselves.
						</p>
						<div class="control-group">
							<label class="control-label" for"username">Username</label>
							<div class="controls">
								<p style="display:inline-block; margin-bottom:0; margin-top: 1px;vertical-align:middle;font-size:14px;height:20px;line-height:20px;padding:4px 6px;"><strong>author</strong></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="authorPassword">Password</label>
							<div class="controls">
								<input type="password" name="authorPassword" id="authorPassword">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="authorPasswordConfirm">Confirm password</label>
							<div class="controls">
								<input type="password" name="authorPasswordConfirm" id="authorPasswordConfirm">
							</div>
						</div>
					<?
					}
					?>
<!-- SITEMAP -->	
					<?php
					if(($GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('deleteBlock') > 0 && $GLOBALS['BAC_PAGE_PERMISSIONS']->checkAction('deleteBucket') > 0) )
					{
					?>
		
						<h6>Sitemap</h6>
						<p>
							BAC works by letting you include content containers dynamically within a page. This
							section lets you pre-define the pages and containers that will exist within your
							website. You can modify this later, but it is recommended that you set up a skeleton
							framework of the site (even if its just an index page!).
						</p>
						<ul id="controllist" class="unstyled"></ul>
						<input name="sitemap" id="sitemap" type="hidden" value="<?php echo $data['sitemap']; ?>"/>
					<?
					}
					?>
						<input name="submitted" type="hidden" value="1" />
						<br />



<button class="btn btn-custom" id="save" type="submit">
Save Configuration
</button>
<?php
include 'footer.php';
?>

