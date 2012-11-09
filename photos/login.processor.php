<?php
	session_start();
	// filename: login.processor.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	//echo $directory_self . '<br/>';
	
	// URL of login script (AKA login.php) - in case of invalid login
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $login . '<br/>';
	
	// URL of user homepage (AKA profile.php) - in case of valid login
	$profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
	
	$seconds = 1;
	
	$con = mysql_connect("localhost", "pictwist", 'secret');
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db("pictwist", $con)
		or die("Unable to select database: " . mysql_error());
	
		//if(isset($_POST['uname']) && isset($_POST['pwd']))
		{
			$email = mysql_real_escape_string($_POST['email']);
			$pwd = mysql_real_escape_string($_POST['pwd']);
			//$pwd_s = hash('sha256', $pwd);
			
			$query = "select email, id from users where email='$email' and password_hash='$pwd';";
			$result = mysql_query($query);
			
			$row = mysql_fetch_array($result);
			$un = $row['email'];
			//echo "email: " . $un . '<br/>';
			$id = $row['id'];
			//echo "id: " . $id . '<br/>';
			if($un == $email)
			{
				$_SESSION['uid'] = $id;
				//echo "uid: " . $_SESSION['uid'];
				header('Location: ' . $profile); 
				//header("Location: list.php");
			}
			else
			{ 
			    header("Refresh: $seconds; URL='$login'");
			    //session_destroy();
			    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'. 
			    '		"http://www.w3.org/TR/html4/strict.dtd">'. 
			    '	<html lang="en">'. 
			    '    	<head>'. 
			    '    		<title>Login Error</title>'. 
			    '    	</head>'. 
			    '    	<body>'. 
			    '    		<div id="Login">'. 
			    '        			<h1>Login Failure</h1>'. 
			    '        			<p>An error has occurred. Please try again.'. 
			    '     		</div>'. 
			    '	</html>'; 
			    exit; 
			} // end error handler 
			
		}
	
	
	mysql_close($con);
?>