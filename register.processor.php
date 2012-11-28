<?php INCLUDE 'include/head.php'; ?>
<?php
	connectToDb();
    //session_start();
	// filename: register.processor.php
	
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
			//Gets information from the POST
			$name = ($_POST['name']);
			$email =($_POST['email']);
			$pwd = ($_POST['password_hash']);
			//$pwd2 =($_POST['password_hash2']); 
			$city = ($_POST['city']);
			$state = ($_POST['state']);
			$country = ($_POST['country']);
			$bio = ($_POST['bio']);

			$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
			
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
					//////can add join_date -- NOW()
					//$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
				
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
						exit();
					}*/
					
					$addUserInfo = "INSERT INTO users(name, email, password_hash, city, state, country, bio)
					values('$name', '$email', '$hash','$city', '$state', '$country', '$bio');";
					$added = mysql_query($addUserInfo);
					//Confirm success with the user
					echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';
					//mysql_close($con);
					//exit();
					$_SESSION['redirect'] = $login;
					
					$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
				}
				else
				{
					//Account already exists for this email so display error message
					echo '<p class="error">An account already exists for this email. Please use a different email address. <br> Return to Register <a href="register.php">return</a>.</p>';

					$name = "";
				}
			}
			else
			{
				echo '<p class="error">You must enter a password.<br>Return to Register <a href="register.php"> return</a>.</p>';
			}
		}
		//bottom code went here
		else //otherwise
		{
			//Generate error 
			echo "<B>Validation Errors:</B>";
			$error_hash = $validator->GetErrors();
			foreach($error_hash as $inpname => $inp_err)
			{
				echo "<p>$inpname : $inp_err</p>\n";
				echo '<p class="error">Return to Register <a href="register.php"> return</a>.</p>';

			}
		}
		
	}
?>
<?php INCLUDE 'include/foot.php' ?>