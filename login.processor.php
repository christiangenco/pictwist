<?php INCLUDE 'include/head.php'; ?>
<?php
	// filename: login.processor.php
	
	require_once "password.php";
	connectToDb();	
	if(isset($_POST['email']) && isset($_POST['pwd']))
	{
		
		$email = mysql_real_escape_string($_POST['email']);
		$pwd = mysql_real_escape_string($_POST['pwd']);
		$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
		
		echo "Email: " . $email .'<br/>';
		echo "Password: " . $pwd.'<br/>';
		echo "hash: " . $hash.'<br/>';
		
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
		echo "<br/> Query: " . $query.'<br/>';
		$result = sql($query);
		$row = mysql_fetch_array($result);
		
		$savedEmail = $row['email'];
		$id = $row['id'];
		$hashedpw = $row['password_hash'];
		echo "SavedEmail: " . $savedEmail.'<br/>';
		echo "id: " . $id.'<br/>';
		echo "hashed: " . $hashedpw.'<br/>';
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
		else */
		if(($savedEmail  == $email) && ($go == true))
		{
			
			$_SESSION['uid'] = $id;
			redirect($profileURL);
			//echo "<script>window.location = '$profileURL'</script>";

		}	
		else
		{
			$_SESSION['error'] = "Password or Username is incorrect. Please try again.";
			$_SESSION['redirect'] = $loginURL;
			redirect($errorURL);
		} // end error handler 
		
	}
	else //if(!isset($_POST['email']) || !isset($_POST['pwd']))
	{
		echo "Username or Password are missing. Please try again.";	
	}
	//mysql_close($con);
?>
<?php INCLUDE 'include/foot.php' ?>