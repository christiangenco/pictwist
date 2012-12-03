<?php INCLUDE 'include/head.php'; ?>
<?php
	require_once "password.php";
    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        //echo $uid;
        connectToDb();
	
	//ADD ADMIN TO THE STMT!!!!!!! AND PASSWORD
	$query = "SELECT id, name, city, state, country, bio FROM users where id='$uid';";
	//echo "<br>Query: " . $query; 
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

<script type="text/javascript">
	setTitle("Edit Profile");
</script>

<a class="returnLink" href="<?php echo $profileURL;?>">< Back to my profile</a>

<div class="centerBox">

<h1>Edit Profile</h1>
	
	<div class="formContainer">

		<form id="My Account" method="post" action="editInfo.processor.php" enctype="multipart/form-data">
		  <input class="m-wrap" type="hidden" name="id" value="<?php echo $id;?>">
		 
			<div class="m-input-prepend">
				<span class="add-on"><label for="fName">Name: </label></span><input id="fName" class="m-wrap" type="text" name="name" value="<?php echo $name;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fp1">Old Password: </label></span><input id="fp1" class="m-wrap" type="password" name="oldpwd" value="<?php echo $oldpwd;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fp2">New Password: </label></span><input id="fp2" class="m-wrap" type="password" name="newpwd" value="<?php echo $newpwd;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fp3">Confirm New Password: </label></span><input id="fp3" class="m-wrap" type="password" name="confirmNew" value="<?php echo $confirmNew;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fCity">City: </label></span><input id="fCity" class="m-wrap" type="text" name="city" value="<?php echo $city;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fState">State: </label></span><input id="fState" class="m-wrap" type="text" name="state" value="<?php echo $state;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="fCountry">Country: </label></span><input id="fCountry" class="m-wrap" type="text" name="country" value="<?php echo $country;?>">
			</div>
			<div class="m-input-prepend">
				<span class="add-on"><label for="editBio">About Me:</label></span><textarea id="editBio" class="m-wrap" type="text" name="bio"><?php echo $bio;?></textarea>
			</div>
			
			<input class="m-btn thinShadow blue" type="submit" name="submit" value="Save Changes">
		</form>
		
		<form method="post" action="profile.php">
			<input class="m-btn thinShadow" type="submit" value="Cancel">
		</form>
			
	</div>		
		
	<div class="boxDivider"></div>
	
	<form method="post" action="deleteAccount.php">
		<input class="m-btn red thinShadow" type="submit" value="Delete Account">
	</form>
		
</div>


<?php INCLUDE 'include/foot.php' ?>