<?php
	session_start();
	// filename: profile.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	
	// URL of user profile page script (AKA profile.php)
	$profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
	
	// URL of search script (AKA search.php)
	$search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';
	
	// URL of upload script (AKA upload.php)
	$upload = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'upload.php';
	
	// URL of logout script (AKA killSession.php)
	$killSession = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'killSession.php';
	
	// URL of error script (AKA error.php)
	$error = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'error.php';
	
	// URL of view script (AKA view.php)
	$view = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'view.php';
	
	// URL of edit script (AKA edit.php)
	$edit = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'edit.php';
	
	// URL of editUserInformation script (AKA editInfo.php)
	$editInfo = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'editInfo.php';
	
	
	if(isset($_SESSION['uid']))
	{
		$uid = $_SESSION['uid'];	
	}
	else
	{
		$_SESSION['error'] = 'Error! You must be logged in to view your photos!';
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
		<script>
			function viewImg(id)
			{
				
			}
		</script>
	</head>
	<body>
		<ul>
			<li><a href="<?php echo $list ?>">My Photos</a></li>
			<li><a href="<?php echo $upload ?>">Upload Photos</a></li>
			<li><a href="<?php echo $search ?>">Search Photos</a></li>
			<li><a href="<?php echo $editInfo ?>">Edit Account</a></li>
			<li style="float:right;"><a href="<?php echo $killSession ?>">Logout</a></li>
		</ul>
		
		<h1>You logged in!</h1>
		<?php
			$con = mysql_connect("localhost", "pictwist", 'secret');
			if(!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
		    
			mysql_select_db("pictwist", $con)
			    or die("Unable to select database: " . mysql_error());
			$query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$uid' order by a.id desc;";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result))
			{
				//echo '"'.$row[path] . '<br/>';
				echo '<form id="' . $row[id] . '" action ="'.$view.'" method="post">'.
					'<input type="hidden" name="p_id" value="'.$row[id].'">'.
					'<img src="'.$row[path].'" alt="pic" style="cursor:pointer;" onclick="document.getElementById(' . $row[id] . ').submit();"></form>';
				//echo '<img src="'.$row[path].'" alt="pic"><br/>';
				//echo '<a onclick="viewImg(' . $row['id'] .');" href="' . $view . '"> <img src="'.$row[path].'" alt="pic"> </a><br/>';
			}
		?>
		
		
	</body>
</html>