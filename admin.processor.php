<?php INCLUDE 'include/head.php'; ?>
<?php
        $uid = $currentUser['id'];
        $admin = $admin['id'];
	//echo "UID: " . $uid;
        connectToDb();
	//require_once "password.php";
	if(isset($_POST['submit']))
        {
            $setAdminID = mysql_real_escape_string($_POST['setAdminID']);
            $setAdminUserName = mysql_real_escape_string($_POST['setAdminUserName']);
            $setAdminUserEmail = mysql_real_escape_string($_POST['setAdminUserEmail']);
            $viewUserInfo = mysql_real_escape_string($_POST['viewUserInfo']);
            $suspendUser = mysql_real_escape_string($_POST['suspendUser']);
            $unsuspendUser = mysql_real_escape_string($_POST['unsuspendUser']);
            $deleteUser = mysql_real_escape_string($_POST['deleteUser']);
            
            //if Admin is going to be set
            if(!empty($setAdminID))
            {
                $query1 = mysql_query("SELECT id from users where id='$setAdminID';");
                if(mysql_numrows($query1) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! ID entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("UPDATE users SET admin='1' WHERE id='$setAdminID';");
                    $_SESSION['error'] = "Administrator has been set";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }
            
            //if Admin needs to be found/set by NAME 
            if(!empty($setAdminUserName))
            {
                $query2 = mysql_query("SELECT * from users where name='$setAdminUserName';");
                if(mysql_numrows($query2) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! Name entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("UPDATE users SET admin='1' WHERE name='$setAdminUserName';");
                    $_SESSION['error'] = "Administrator has been set";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }
            
            //if Admin need to be found/set by EMAIL
            if(!empty($setAdminUserEmail))
            {
                $query3 = mysql_query("SELECT * from users where email='$setAdminUserEmail';");
                if(mysql_numrows($query3) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! Email entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("UPDATE users SET admin='1' WHERE email='$setAdminUserEmail';");
                    $_SESSION['error'] = "Administrator has been set";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }
            
            //view users information from EMAIL
            if(!empty($viewUserInfo))
            {
                $query4 = mysql_query("SELECT * from users where email='$viewUserInfo';");
                if(mysql_numrows($query4) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! Email entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $row = mysql_fetch_array($query4);
                    $usersid = $row['id'];
                    $email = $row['email'];
                    $name = $row['name'];
                    $pwd = $row['password_hash'];
                    $city = $row['city'];
                    $state = $row['state'];
                    $country = $row['country'];
                    $bio = $row['bio'];
                    $admin = $row['admin'];
                    $lastUpdate = $row['updated_at'];
                    $createdOn = $row['created_at'];
                    $lastLogin = $row['last_login'];
                    
                    echo "<br><b>User's ID: </b>" . $usersid;
                    echo "<br><b>Is Admin (0 for No, 1 for yes):  </b>" . $admin;
                    echo "<br><b>Name: </b>" . $name;
                    echo "<br><b>Email: </b>" . $email;
                    echo "<br><b>Password: </b>" . $pwd;
                    echo "<br><b>City: </b>" . $city;	
                    echo "<br><b>State: </b>" . $state;
                    echo "<br><b>Country: </b>" . $country;	
                    echo "<br><b>About that User: </b>" . $bio;
                    echo "<br><b>Last login: </b>" . $lastLogin;
                    echo "<br><b>Last update: </b>" . $lastUpdate;
                    echo "<br><b>Created on: </b>" . $createdOn;
                    //echo "<br><b>Member since </b>" . date("F j, Y", strtotime($tstamp));
                    //echo "<br><b>Last login was </b>" . date("F j, Y", strtotime($lastUpdate)); 
                    echo '<p class="error"><br>Back to Administrator page <a href="admin.php"><b> here </b></a>.</p>';
                }
            }
            
            //SUSPEND user found by EMAIL
            if(!empty($suspendUser))
            {
                //echo "HERE<br/>";
                $query5 = mysql_query("SELECT * from users where email='$suspendUser';");
                if(mysql_numrows($query5) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! Email entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("UPDATE users SET suspended=1 WHERE email='$suspendUser';");
                    echo $query . "<br/>";
                    $_SESSION['error'] = "User has been suspended";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }

             //UNSUSPEND user found by EMAIL
            if(!empty($unsuspendUser))
            {
                //echo "HERE<br/>";
                $query7 = mysql_query("SELECT * from users where email='$unsuspendUser';");
                if(mysql_numrows($query7) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered     
                    $_SESSION['error'] = "ERROR! Email entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("UPDATE users SET suspended=0 WHERE email='$unsuspendUser';");
                    echo $query . "<br/>";
                    $_SESSION['error'] = "User has been unsuspended";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }
            
            //DELETE user found by EMAIL
            if(!empty($deleteUser))
            {
                $query6 = mysql_query("SELECT * from users where email='$deleteUser';");
                if(mysql_numrows($query6) ==0)
                {
                    //id was NOT found - therefore the user/email is not registered 	
                    $_SESSION['error'] = "ERROR! Email entered is not registered";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
                else 
                {
                    $query = mysql_query("DELETE FROM users WHERE email='$deleteUser';");
                    $_SESSION['error'] = "User has been deleted from database";
                    $_SESSION['redirect'] = $adminURL;
                    redirect($errorURL);
                }
            }
            
        }
?>

<?php INCLUDE 'include/foot.php' ?>