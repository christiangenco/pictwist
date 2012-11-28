<?php
  // Connect to the database and get the data of interest
    //filename: register.php
    //session_start();
	// filename: login.processor.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	//echo $directory_self . '<br/>';
	
	// URL of login script (AKA login.php) - in case of invalid login
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $login . '<br/>';
	
	// URL of user homepage (AKA profile.php) - in case of valid login
	$profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
	//
    
	$con = mysql_connect("localhost", "pictwist", 'secret');
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	else
		echo "connected!!!";
		
	mysql_select_db("pictwist", $con)
		or die("Unable to select database: " . mysql_error());


    $id = $_GET["id"];

    //ADD ADMIN TO THE STMT!!!!!!! AND PASSWORD
  $query = "SELECT name, email, city, state, country, bio FROM users where id=$id;";

    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    
    $name = $row['name'];
    $useremail = $row['email'];
    $city = $row['city'];
    $state = $row['state'];
    $country = $row['country'];
    $bio = $row['bio'];
    //$hashedpw = $row['password_hash'];
    //$admin = $row['admin'];

 /* $yes_status = "";
  $no_status = "";
  if ($ad == 1) $yes_status = "checked";
  if ($ad == 0) $no_status = "checked";
  */
?>

<form method="post" action="editInfo.php">
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <ul>
    <li>Name: <input type="text" name="name" value="<?php echo $name;?>">
    <li>Email: <input type="text" name="email" value="<?php echo $email;?>">
    <li>City: <input type="text" name="city" value="<?php echo $city;?>">
    <li>State: <input type="text" name="state" value="<?php echo $state;?>">
    <li>Country: <input type="text" name="country" value="<?php echo $country;?>">
    <li>About Me: <input type="text" name="bio" value="<?php echo $bio;?>">
    <!-- <li>Admin: <input type="radio" name="isadmin" value="yes" <?php echo $yes_status;?>>Yes
        <input type="radio" name="isadmin" value="no" <?php echo $no_status;?>>No -->
  </ul>

  <input type="submit" value="Submit">
</form>
