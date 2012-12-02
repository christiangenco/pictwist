<?php INCLUDE 'include/head.php'; ?>
<?php
        $uid = $currentUser['id'];
	//echo "UID: " . $uid;
        connectToDb();
	require_once "password.php";
	

	if(isset($_POST['submit']))
	{//if the form is submitted DO THIS:

			$name = mysql_real_escape_string($_POST['name']);
                        $oldpwd = mysql_real_escape_string($_POST['oldpwd']);
                        $newpwd = mysql_real_escape_string($_POST['newpwd']);
			$confirmNew = mysql_real_escape_string($_POST['confirmNew']);
			$city = mysql_real_escape_string($_POST['city']);
			$state = mysql_real_escape_string($_POST['state']);
			$country = mysql_real_escape_string($_POST['country']);
			$bio = mysql_real_escape_string($_POST['bio']);
                        //echo "<br>Old pd: " . $oldpwd;
			/*
			echo "<br>Name= " . $name;
                        echo "<br>Old pd: " . $oldpwd;
                        echo "<br>new pd: " . $newpwd;
                        echo "<br>city= " . $city;
                        echo "<br>state= " . $state;
                        echo "<br>country= " . $country;
                        echo "<br>bio= " . $bio;
                        */
		
			//checks that the entered new passwords match 
			if($newpwd == $confirmNew)
			{
				if(strlen($newpwd) < 6)
				{
					$_SESSION['error'] = "Password must be at least 6 characters. Please try again.";
					$_SESSION['redirect'] = $editInfoURL;
					redirect($errorURL);	
				}
				else
				{
					$hashOld = password_hash($oldpwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
					$hashNew = password_hash($newpwd, PASSWORD_BCRYPT, array("cost" => 7, "salt" => "usesomesillystringforf"));
					//echo "<br>Old hash: " . $hashOld;
					//echo "<br>New hash: " . $hashNew;
					/*
					//Verify the password	
					if (password_verify($oldpwd, $hashOld))
					{
						$go = true;
						echo "<br/> --- password hash worked!!!";
					}else{
						$go = false;
						echo "<br/> --- password hash FAIL!!!";
					}
					*/
					//mysql query to get the hased password from specified user id 
					$queryOldPwd = mysql_query("SELECT password_hash FROM users WHERE id='$uid';");
					$row = mysql_fetch_array($queryOldPwd);
					$savedOldPwd = $row['password_hash'];
					//echo "<br>*QUERY: " . $queryOldPwd;
					//echo "<br>*savedp: " . $savedOldPwd;
					//check to see if saved old password matched the entered old hashed password 
					if($savedOldPwd == $hashOld)
					{
					    $match = true;
					}
					else
					{
					    $match = false;
					}
					
					/////////////////////////////
					//there has to be name entered
					if (!empty($name))// && !empty($oldpwd))
					{
					    //if old password matches and there is a new password -- update all including password
					    if($match==true && !empty($newpwd))
					    {
						echo "<br> 1 New password has been set";
						$updateUserInfo = "UPDATE users SET name='$name', password_hash='$hashNew', city='$city', state='$state', country='$country', bio='$bio' WHERE id='$uid';";
						$updated = mysql_query($updateUserInfo);
						//Confirm success with the user
						$_SESSION['error'] = "Your account information has been successfully updated. And your new passwords has been set";
						$_SESSION['redirect'] = $profileURL;
						redirect($errorURL);
					    }
					    //else if old password matches BUT new password is not entered -- update all info EXCEPT password 
					    else if($match==true && empty($newpwd))
					    {
						echo "<br> 2 no new password set";
						$updateUserInfo = "UPDATE users SET name='$name', city='$city', state='$state', country='$country', bio='$bio' WHERE id='$uid';";
						$updated = mysql_query($updateUserInfo);
						//Confirm success with the user
						$_SESSION['error'] = "Your account information has been successfully updated.";
						//echo '<p>Your account information has been successfully updated.</p>'; //You\'re now ready to <a href="login.php">log in</a>.</p>';
						$_SESSION['redirect'] = $profileURL;
						redirect($errorURL);
					    }
					    //else if old password does NOT match (or is empty) but there IS a new password entered -- error telling user to try again
					    else if(($macth==false) && !empty($newpwd))
					    {
						echo "<br> 3 old password doesnt match";
						$_SESSION['error'] = "Old password does not match. Cannot change password, please try again.";
						$_SESSION['redirect'] = $editInfoURL;
						redirect($errorURL);                               
					    }
					    //otherwise if oldpassword and newpassword are left blank -- update all info except password 
					    else if(empty($oldpwd) && empty($newpwd))
					    {
						echo "<br> 4 no new password set2";
						$updateUserInfo = "UPDATE users SET name='$name', city='$city', state='$state', country='$country', bio='$bio' WHERE id='$uid';";
						$updated = mysql_query($updateUserInfo);
						//Confirm success with the user
						$_SESSION['error'] = "Your account information has been successfully updated.";
						//echo '<p>Your account information has been successfully updated.</p>'; //You\'re now ready to <a href="login.php">log in</a>.</p>';
						$_SESSION['redirect'] = $editInfoURL;
						redirect($errorURL);  
					    }
					}
					else //name must be entered 
					{
					    //echo "will ps or user is wrong";
					    $_SESSION['error'] = "You must enter a Name";
					    $_SESSION['redirect'] = $editInfoURL;
					    redirect($errorURL);
					}
				}
			}//ends password matching loop
			else	//Error displayed that passwords do NOT match 
			{
				$_SESSION['error'] = "New Passwords do not match.";
				$_SESSION['redirect'] = $editInfoURL;
				redirect($errorURL);	
			}
	}//ends 'submit' loop
?>
<?php INCLUDE 'include/foot.php' ?>