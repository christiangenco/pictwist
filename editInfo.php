<?php INCLUDE 'include/head.php'; ?>
<?php
	require_once "password.php";
    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        echo $uid;
        connectToDb();
	
	//ADD ADMIN TO THE STMT!!!!!!! AND PASSWORD
	$query = "SELECT id, name, city, state, country, bio FROM users where id='$uid';";
	echo "<br>Query: " . $query; 
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	$id = $row['id'];
	$name = $row['name'];
	$oldpwd = $row['password_hash'];
	$city = $row['city'];
	$state = $row['state'];
	$country = $row['country'];
	$bio = $row['bio'];

	//$admin = $row['admin'];
	
	/* $yes_status = "";
	$no_status = "";
	if ($ad == 1) $yes_status = "checked";
	if ($ad == 0) $no_status = "checked";
	*/
	
	
    }

?>
<?php //INCLUDE 'include/foot.php' ?>


<form id="My Account" method="post" action="editInfo.processor.php" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <ul>
    <li>Name: <input type="text" name="name" value="<?php echo $name;?>">
    <li>Old Password: <input type="password" name="oldpwd" value="<?php echo $oldpwd;?>">
    <li>New Password: <input type="password" name="newpwd" value="<?php echo $newpwd;?>">
    <li>Confirm New Password: <input type="password" name="confirmNew" value="<?php echo $confirmNew;?>">
    <li>City: <input type="text" name="city" value="<?php echo $city;?>">
    <li>State: <input type="text" name="state" value="<?php echo $state;?>">
    <li>Country: <input type="text" name="country" value="<?php echo $country;?>">
    <li>About Me: <input type="text" name="bio" value="<?php echo $bio;?>">
    <!-- <li>Admin: <input type="radio" name="isadmin" value="yes" //<?php echo $yes_status;?>>Yes
        <input type="radio" name="isadmin" value="no" //<?php echo $no_status;?>>No -->
  </ul>

  <input type="submit" name="submit" value="Save Changes">
</form>
<form method="post" action="profile.php">
	<br><input type="submit" value="Cancel">
</form>
