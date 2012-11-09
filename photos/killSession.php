<?php
	session_start();
	// filename: killSession.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	//echo $directory_self . '<br/>';
	
	// URL of user profile page script (AKA login.php)
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $index . '<br/>';
	
	$seconds = 1;
	
	header("Refresh: $seconds; URL='$login'");
	
	if(isset($_SESSION['error']))
	{
		echo $_SESSION['error'] . '<br/>';
	}
	echo '<p>You will now be logged out.</p>';
	
	session_destroy();
?>