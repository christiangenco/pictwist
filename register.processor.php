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
		$validator = new FormValidator();				//PHP Validation
		$validator->addValidation("name","req","Please fill in Name");
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
			$pwd2 =($_POST['password_hash2']); 
			$city = ($_POST['city']);
			$state = ($_POST['state']);
			$country = ($_POST['country']);
			$bio = ($_POST['bio']);

			if(strlen($pwd) < 6)
			{
				$_SESSION['error'] = "Password must be at least 6 characters. Please try again.";
				$_SESSION['redirect'] = $registerURL;
				redirect($errorURL);	
			}
			else
			{
				
				//check to make sure that the passwords match
				if($pwd == $pwd2)
				{
					$hash = password_hash($pwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
					
					//checks to make sure that name, email and password are NOT empty
					if (!empty($name) && !empty($email) && !empty($pwd))
					{
						//Make sure email is not already registered 
						$query = "SELECT email, id FROM users WHERE email='$email'";
						$result = mysql_query($query);
						if(mysql_numrows($result) == 0)
						{//email was NOT found it DB so information is entered/saved in db
							
							//insertion mysql statement 
							$addUserInfo = "INSERT INTO users(name, email, password_hash, city, state, country, bio)
							values('$name', '$email', '$hash','$city', '$state', '$country', '$bio');";
							$added = mysql_query($addUserInfo);
							
							$query = "SELECT id, email FROM users WHERE email='$email';";
							$result = mysql_query($query);
							$row = mysql_fetch_array($result);
							$newid = $row['id'];
							//echo "<br>New id: " . $newid;
							$defaultAlbum = mysql_query("INSERT INTO albums(title, user_id) VALUES('Default', $newid);");
							//Confirm successful registration with the user
							$_SESSION['error'] = "Your new account has been successfully created! Please log in to verify your account";
							$_SESSION['redirect'] = $loginURL;	//redirected to login to verify username & password
							redirect($errorURL);
						}
						else	//otherwise email DOES exist in DB
						{
							//Account already exists for this email so display error message
							//echo '<p class="error"> <br> Return to Register <a href="register.php">return</a>.</p>';
							$_SESSION['error'] = "ERROR!! <br> An account already exists for this email.";
							$_SESSION['redirect'] = $loginURL;
							redirect($errorURL);
						}
					}
					else	//name, email, or password were left empty
					{
						//Message is displayed for user to enter valid name, email, and password 
						//echo '<p class="error"><br>Return to Register <a href="register.php"> return</a>.</p>';
						$_SESSION['error'] = "You must enter a valid Name, Email, and Password.";
						$_SESSION['redirect'] = $registerURL;
						redirect($errorURL);				
					}
				}
				else	//Message is displayed that Passwords do not match, so try again 
				{
					$_SESSION['error'] = "Password does not match. Please try again.";
					$_SESSION['redirect'] = $registerURL;
					redirect($errorURL);	
				}
			}
			
		}
		else //otherwise validation of form is not ok so error is displayed 
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
	}//ends 'submit' loop
?>
<?php INCLUDE 'include/foot.php' ?>