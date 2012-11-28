<?php INCLUDE 'include/head.php'; ?>
<?php
        $uid = $currentUser['id'];
        connectToDb();
	
	if(isset($_POST['submit']))
	{//if the form is submitted DO THIS:
                    
			$name = ($_POST['name']);
			$city = ($_POST['city']);
			$state = ($_POST['state']);
			$country = ($_POST['country']);
			$bio = ($_POST['bio']);
                        echo "Name= " . $name;
                        echo "city= " . $city;
                        echo "state= " . $state;
                        echo "country= " . $country;
                        echo "bio= " . $bio;

			/////////////////////////////
			if (!empty($name))
			{
					$updateUserInfo = "UPDATE users SET name='$name', city='$city', state='$state', country='$country', bio='$bio' WHERE id='$uid';";
					$updated = mysql_query($updateUserInfo);
					//Confirm success with the user
                                        $_SESSION['error'] = "Your account information has been successfully updated.";
					//echo '<p>Your account information has been successfully updated.</p>'; //You\'re now ready to <a href="login.php">log in</a>.</p>';
                                        $_SESSION['redirect'] = $editInfoURL;
                                        redirect($errorURL);
			}
			//}
			else
			{
                            //echo "will ps or user is wrong";
			    $_SESSION['error'] = "You must enter a Name.";
                            $_SESSION['redirect'] = $editInfoURL;
			    redirect($errorURL);
			}
	}
?>
<?php INCLUDE 'include/foot.php' ?>