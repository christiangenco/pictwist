<?php
	session_start();
	// filename: edit.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	
	// URL of logout script (AKA killSession.php)
	$killSession = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'killSession.php';
	
	// URL of user profile page script (AKA list.php)
	$list = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'list.php';
	
	// URL of search script (AKA search.php)
	$search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';
	
	// URL of edit script (AKA edit.php)
	$edit = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'edit.php';
	
	// URL of upload script (AKA upload.php)
	$upload = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'upload.php';
	
	if(isset($_SESSION['uid']))
	{
		$uid = $_SESSION['uid'];	
	}
	else
	{
		$_SESSION['error'] = 'You must be logged in to view your photos!';
		header('Location: ' . $killSession); 
	}
?>

<html>
	<head>
		<title>Profile</title>
		<style type="text/css">
			ul{list-style-type:none; margin:0; padding:0; background-color:blue; padding:5px;}
			li{display:inline; color:white; padding:0px 50px 0px 10px;}
			li a{color:white;}
		</style>
	</head>
	<body>
		<ul>
			<li><a href="<?php echo $list ?>">My Photos</a></li>
			<li><a href="<?php echo $upload ?>">Upload Photos</a></li>
			<li><a href="<?php echo $search ?>">Search Photos</a></li>
			<li style="float:right;"><a href="<?php echo $killSession ?>">Logout</a></li>
		</ul>
		
		<h1>You logged in!</h1>
	</body>
</html>