<?php INCLUDE 'include/head.php'; ?>
<?php
	// filename: login.processor.php
	require_once "password.php";
	connectToDb();
	if(!empty($_POST['email']) && !empty($_POST['pwd']))//isset($_POST['email']) && isset($_POST['pwd']))
	{
		
		$email = mysql_real_escape_string($_POST['email']);
		$pwd = mysql_real_escape_string($_POST['pwd']);
		$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
					//Verify the password	
			if (password_verify($pwd, $hash))
			{
				$go = true;
				echo "<br/> --- password hash worked!!!";
			}else{
				$go = false;
				echo "<br/> --- password hash FAIL!!!";
			}
			
		$query1 = mysql_query("SELECT * FROM users WHERE email='$email';");
		if(mysql_numrows($query1) ==0)
		{
			
			echo '<p>This email is not registered. You\'re can register <a href="register.php">here</a>.</p>';
			echo '<p>			  	Or return to <a href="login.php">login</a>.</p>';
		}
		else
		{
			
			$query = "SELECT email, id FROM users WHERE email='$email' AND password_hash='$hash';";
			echo "<br/> Query: " . $query.'<br/>';
			$result = sql($query);
			$row = mysql_fetch_array($result);
			
			$savedEmail = $row['email'];
			$id = $row['id'];
			$hashedpw = $row['password_hash'];
			
			if(($savedEmail  == $email) && ($go == true))//($hashedpw == $hash))//($go == true))
			{
				//echo "will sign in";
				$_SESSION['uid'] = $id;
				redirect($profileURL);
				//echo "<script>window.location = '$profileURL'</script>";
	
			}
			else
			{
				//echo "will ps or user is wrong";
				$_SESSION['error'] = "Username or Password is incorrect. Please try again.";
				$_SESSION['redirect'] = $loginURL;
				redirect($errorURL);
			} // end error handler
		}	
	}
	else if(empty($_POST['email']) || empty($_POST['pwd']))
	{
		$_SESSION['redirect'] = $loginURL;
		redirect($loginURL);
	}
	else
	{
		//echo "Username or Password are missing. Please try again.";
		$_SESSION['error'] = "Username or Password is missing. Please try again!";
		$_SESSION['redirect'] = $loginURL;
		redirect($loginURL);
	}
	
?>
<?php INCLUDE 'include/foot.php' ?>