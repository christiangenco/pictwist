<?php INCLUDE 'include/head.php'; ?>
<?php
	// filename: login.processor.php
	require_once "password.php";
	connectToDb();
	
	//make sure that email and password are NOT empty 
	if(!empty($_POST['email']) && !empty($_POST['pwd']))//isset($_POST['email']) && isset($_POST['pwd']))
	{
		//get the info entered - email, password
		$email = mysql_real_escape_string($_POST['email']);
		$pwd = mysql_real_escape_string($_POST['pwd']);
		$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf")); 	//hashes the email 
			//Verify the password	
			if (password_verify($pwd, $hash))
			{
				$go = true;
				echo "<br/> --- password hash worked!!!";
			}
			else
			{
				$go = false;
				echo "<br/> --- password hash FAIL!!!";
			}
		
		//MySQL query to check if the email exists in DB
		$query1 = mysql_query("SELECT * FROM users WHERE email='$email';");
		if(mysql_numrows($query1) ==0)
		{
			//email was NOT found - therefore the user/email is not registered 	
			echo '<p>This email is not registered. You\'re can register <a href="register.php">here</a>.</p>';
			echo '<p>			  	Or return to <a href="login.php">login</a>.</p>';
		}
		else	//else the email WAS found
		{
			//query to find email and id that belong to the entered email and password 
			$query = "SELECT email, id FROM users WHERE email='$email' AND password_hash='$hash';";		
			echo "<br/> Query: " . $query.'<br/>';
			$result = sql($query);
			$row = mysql_fetch_array($result);
			
			$savedEmail = $row['email'];
			$id = $row['id'];
			$hashedpw = $row['password_hash'];
			
			//if the savedEmail matches the entered email AND the passwords are verified then go on to profile 
			if(($savedEmail  == $email) && ($go == true))//($hashedpw == $hash))//($go == true))
			{
				//echo "will sign in";
				$_SESSION['uid'] = $id;
				redirect($profileURL);
				//echo "<script>window.location = '$profileURL'</script>";
			}
			else	//otherwise alert user that the username or password is wrong and try again 
			{
				//echo "will ps or user is wrong";
				$_SESSION['error'] = "Username or Password is incorrect. Please try again.";
				$_SESSION['redirect'] = $loginURL;
				redirect($errorURL);
			} // end error handler
		}	
	}
	//check if either the email slot or the password slot are empty and automatically redirects to the login in again
	else if(empty($_POST['email']) || empty($_POST['pwd']))
	{
		$_SESSION['redirect'] = $loginURL;
		redirect($loginURL);
	}
	/*
	else
	{
		//echo "Username or Password are missing. Please try again.";
		$_SESSION['error'] = "Username or Password is missing. Please try again!";
		$_SESSION['redirect'] = $loginURL;
		redirect($loginURL);
	}*/
	
?>
<?php INCLUDE 'include/foot.php' ?>