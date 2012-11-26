<?php
    //session_start();
	// filename: register.processor.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	//echo $directory_self . '<br/>';
	
	// URL of login script (AKA login.php) - in case of invalid login
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $login . '<br/>';
	
	// URL of user homepage (AKA profile.php) - in case of valid login
	$profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
	//
	//echo "IN REGI PROCESSOR!!!";
	
	$con = mysql_connect("localhost", "pictwist", 'secret');
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	else
		echo "connected!!!";
		
	mysql_select_db("pictwist", $con)
		or die("Unable to select database: " . mysql_error());
	
	//include the main validation script
	require_once "formvalidator.php";
	require_once "password.php";
	//$registered=false;
	
	if(isset($_POST['submit']))
	{//if the form is submitted DO THIS:
		
		//Setup Validations
		$validator = new FormValidator();	//PHP Validation
		$validator->addValidation("name","req","Please fill in Name");	//MIGHT have to change "name", "email" etc!!!!
		$validator->addValidation("email","email", "The input for Email should be a valid email");
		$validator->addValidation("email","req","Please fill in Email");
		
		//Validate the form 
		if($validator->ValidateForm())
		{//Validation success. 
			
			//Proceed with processing the form (saving to Database)
			//echo"<h2>Validation Success!</h2>";
			//$show_form=false;
			
			//Gets information from the POST
			$name = ($_POST['name']);
			$email =($_POST['email']);
			$pwd = ($_POST['password_hash']);
			//$pwd2 =($_POST['password_hash2']); 
			$city = ($_POST['city']);
			$state = ($_POST['state']);
			$country = ($_POST['country']);
			$bio = ($_POST['bio']);

			//$bio = mysql_real_escape_string($_POST['bio']);
			/////////////////////////////
			
			if (!empty($name) && !empty($email) && !empty($pwd))// && !empty($password2) && ($password1 == $password2)) {
			{
				//Make sure email is not already registered 
				$query = "SELECT email, id FROM users WHERE email='$email'";
				$result = mysql_query($query);
				if(mysql_numrows($result) == 0)
				{
					//Email is unique so insert the data into the database
					//can add join_date -- NOW()
					$addUserInfo = "INSERT INTO users(name, email, password_hash, city, state, country, bio)
					values('$name', '$email', '$hash','$city', '$state', '$country', '$bio');";
					mysql_query($addUserInfo);
					//Confirm success with the user
					echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';
					mysql_close($con);
					exit();
				}
				else
				{
					//Account already exists for this email so display error message
					echo '<p class="error">An account already exists for this email. Please use a different email address. <br> Return to Register<a href="register.php">return</a>.</p>';

					$name = "";
				}
			}
			else
			{
				echo '<p class="error">You must enter all required fields.<br>Return to Register <a href="register.php"> return</a>.</p>';
			}
		}/*	
			
			$query = "SELECT email, id FROM users WHERE email='$email'";
			//echo "QUERY: " . $query . "<br/>";
			$result = mysql_query($query);
			
			$row = mysql_fetch_array($result);
			$savedEmail = $row['email'];
			$id = $row['id'];
			
			if($savedEmail == $email)
			{
				echo "Email already has an account!";
				//$_SESSION['uid'] = $id;
				//REDIRECTS WITHOUT WARNING SAYING THAT THE EMAIL ENTERED ALREADY IS A REGISTERED MEMEBER!!!!!!!!
				//echo "<script>window.location = '$login'</script>";
				//header('Location: ' . $login); 
				//header("Location: list.php");
				
			}
			else
			{
				$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
				
				/*just to check that the hashing works*/
				//echo "HASH: " . $hash . "\n";
				//echo "PS: " . $pwd;
				/*
				if (password_verify($pwd, $hash))
				{
					echo " --- password hash works!!!";
				}
				else
				{
					echo " --- password hash FAIL!!!";
				}
				/**********************/
				/*
				$addUserInfo = "INSERT INTO users(name, email, password_hash, city, state, country, bio)
					values('$name', '$email', '$hash','$city', '$state', '$country', '$bio');";
				//echo "info ADDED****: '$addUserInfo' ";
				$added = mysql_query($addUserInfo);
				//header('Location: ' . $login);
				$registered = true;
				//REDIRECTS TO LOGIN
				echo "<script>window.location = '$login'</script>";
			}
		}*/
		else //otherwise
		{
			//Generate error 
			echo "<B>Validation Errors:</B>";
			$error_hash = $validator->GetErrors();
			foreach($error_hash as $inpname => $inp_err)
			{
				echo "<p>$inpname : $inp_err</p>\n";
			}
		}
		
	}
	//echo "You are Registered!";
	//echo "<script>window.location = '$profile'</script>";
	mysql_close($con);	
?>