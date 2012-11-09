<?php
	session_start();
	// filename: view.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	
	// URL of login script (AKA login.php) - in case of invalid login
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $login . '<br/>';
	
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
	
	//echo "p: " . $_POST['p_id'];
?>

<html>
	<head>
		<title>View Photo</title>
			<style type="text/css">
				ul{list-style-type:none; margin:0; padding:0; background-color:blue; padding:5px;}
				li{display:inline; color:white; padding:0px 50px 0px 10px;}
				li a{color:white;}
			</style>
	</head>
	<body>

<?php	
	if(isset($_POST['p_id']) || $_SESSION['img'])
	{
		if(isset($_POST['p_id']))
		{
			$pid = $_POST['p_id'];
			$_SESSION['img'] = $pid;
		}
		else {$pid = $_SESSION['img'];}
		
		echo ''.
		'		<ul>'.
		'';
		if(isset($_SESSION['uid']))
		{
			$uid = $_SESSION['uid'];
			
			echo ''.
				'	<li><a href="'.$profile.'">My Photos</a></li>'.
				'	<li><a href="'.$upload.'">Upload Photos</a></li>'.
				'	<li><a href="'.$search.'>Search Photos</a></li>'.
				'	<li style="float:right;"><a href="'.$killSession.'">Logout</a></li>'.
				'</ul>'.
			'';
		}
		else
		{
			echo ''.
				'	<li><a href="'.$search.'">Search Photos</a></li>'.
				'	<li style="float:right;"><a href="'.$login.'">Login</a></li>'.
				'</ul>'.
			'';
		}
		
		$con = mysql_connect("localhost", "pictwist", 'secret');
		if(!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
	    
		mysql_select_db("pictwist", $con)
		    or die("Unable to select database: " . mysql_error());
		    
		$query = "select title, path from photos where id='$pid';";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$path = $row[path];
		$title = $row[title];
		
		$query = "select text, c.updated_at, p.id from photos p JOIN comments c where p.id = '$pid' AND p.id = 'c.photo_id' order by c.updated_at desc;";
		$result_comments = mysql_query($query);
		$query = "select text, t.updated_at, p.id, type from photos p JOIN tags t where p.id = '$pid' AND p.id = 't.photo_id' order by t.type desc;";
		$result_tags = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
			//echo '"'.$row[path] . '<br/>';
			echo '<form id="' . $row[id] . '" action ="'.$view.'" method="post">'.
				'<input type="hidden" name="p_id" value="'.$row[id].'">'.
				'<img src="'.$row[path].'" alt="pic" style="cursor:pointer;" onclick="document.getElementById(' . $row[id] . ').submit();"></form>';
			//echo '<img src="'.$row[path].'" alt="pic"><br/>';
			//echo '<a onclick="viewImg(' . $row['id'] .');" href="' . $view . '"> <img src="'.$row[path].'" alt="pic"> </a><br/>';
		}
		
	}
	else
	{
		$_SESSION['error'] = 'You must select a photo to view!';
		header('Location: ' . $error); 
	}
?>
	<div>
	<div class="pic" style="float:top; float:left; padding:50px;">
		<img src="<?php echo $path;?>" alt="pic">
		<p><?php echo $title ?></p>
	</div>
	<div class="info" style="float:tope; float:left; padding:50px;">
		<?php
			while($row = mysql_fetch_array($result_tags))
			{
				echo '<div class="tag">'.
					$row[type] . ': ' . $row[text] .
					'</div>';
			}
			if($uid > 0)
			{
				echo '<form method="post" action="' . $tag_processor . '">'.
					'type:'.
					'<select name="tag">'.
					'<option value="location">Location</option>'.
					'<option value="camera type">Camera Type</option>'.
					'<option value="color">Color</option>'.
					'<option value="keyword">Keyword</option>'.
					'<option value="person">Person</option>'.
					'</select>'.
					'<br/>'.
					'tag: <input type="text" name="tag" value="tag"><br/>'.
					'<input type="submit" value="Create Tag">'.
					'</form>';
			}
		?>
	</div>
	</div>
	<div class="comments" style="float:left; clear:both; padding:0px 0px 0px 50px;">
		<?php
			while($row = mysql_fetch_array($result_comments))
			{
				echo '<div class="comment">'.
					$row[id] . ' said ' . $row[text] . '<br/>'.
					'date: ' . $row[updated_at] .
					'</div>';
			}
			if($uid > 0)
			{
				echo '<form method="post" action="' . $comment_processor . '">'.
					'<input type="text" name="tag" value="comment here..."><br/>'.
					'<input type="submit" value="Submit Comment">'.
					'</form>';
			}
		?>
	</div>
	</body>
</html>