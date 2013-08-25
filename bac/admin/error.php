<?php
    include 'auth.php';
	
	if(isset($_SESSION['m']))
	{
		$message = $_SESSION['m'];
	} else {
		$message = "";
	}
	if(isset($_SESSION['bp']))
	{
		$backpage = $_SESSION['bp'];
	} else {
		$backpage = get_absolute_uri("index.php");
	}
	
	unset($_SESSION['m']);
	unset($_SESSION['bp']);
?>

<?php
include 'header.php';
?>
<p>An error has occured: <?php echo $message;?> </p>
<p><a href='<?php echo $backpage;?>'> Please click here to return to the previous page, and try your request again. </a></p>

<?php
include 'footer.php';
?>
