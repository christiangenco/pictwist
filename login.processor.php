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
	
	// URL of user homepage (AKA profile.php) - in case of valid login
	$register = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'register.php';

	require_once "password.php";
	
	$con = mysql_connect("localhost", "pictwist", 'secret');
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("pictwist", $con)
		or die("Unable to select database: " . mysql_error());
	
	if(isset($_POST['email']) && isset($_POST['pwd']))
	{
		
		$email = mysql_real_escape_string($_POST['email']);
		$pwd = mysql_real_escape_string($_POST['pwd']);
		$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
		
		//Verify the password	
		if (password_verify($pwd, $hash))
		{
			$go = true;
			echo " --- password hash works!!!";
		}else{
			$go = false;
			echo " --- password hash FAIL!!!";
		}
		
		$query = "SELECT email, id FROM users WHERE email='$email' AND password_hash='$hash';";
		echo "Query: " . $query;
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$savedEmail = $row['email'];
		$id = $row['id'];
		$hashedpw = $row['password_hash'];
			/*if($savedEmail == $email)
			{
				echo "Email already has an account!";
				$_SESSION['uid'] = $id;
				//REDIRECTS WITHOUT WARNING SAYING THAT THE EMAIL ENTERED ALREADY IS A REGISTERED MEMEBER!!!!!!!!
				echo "<script>window.location = '$login'</script>";
				//header('Location: ' . $login); 
				//header("Location: list.php");
				
			}

		if($email != $useremail)
		{
			echo "Email not Registered.";
		}
		else if(($useremail == $email) && ($go == false))
		{
			echo "user doesnt exist"; //"invalid password";
		}
		else */if(($savedEmail  == $email) && ($go == true))
		{
			
			$_SESSION['uid'] = $id;
			echo "<script>window.location = '$profile'</script>";
		}
		
		else
		{
			echo "Password or Username is incorrect. Please try again.";
			//header("loaction: '$login'");
		
		    //echo "<script>window.location = '$login'</script>";
		    echo "Something went wrong!!!";
		    
		    
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
		    //echo "<script>window.location = '$login'</script>";
		    exit;//("<script>window.location = '$login'</script>");
		    
			
		} // end error handler 
		
	}
	else //if(!isset($_POST['email']) || !isset($_POST['pwd']))
	{
		echo "Username or Password are missing. Please try again.";	
	}
	mysql_close($con);
?>