<?php INCLUDE 'include/head.php';?>

<?php
	redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to upload photos!");

    // set a max file size for the html upload form 
    $max_file_size = 10000000; // size in bytes (AKA 10 MB)

    $uid = $currentUser['id'];
        
    connectToDb();
        
    $query = "select id, title from albums where user_id='".$uid."';";
    $result_albums = sql($query);
?>

<a class="returnLink" href="<?php echo $profileURL;?>">< Back to my profile</a>

<div class="centerBox">
	<div class="formContainer">

	<form id="Upload" action="<?php echo $uploadHandlerURL ?>" enctype="multipart/form-data" method="post"> 
	 
		<h1> 
			Upload a Picture to 
			<select name="a_id">
				<?php
					while($row = mysql_fetch_array($result_albums))
					{
						echo '<option value="' . $row['id'] . '"';
						if($_REQUEST['a_id']===$row['id']) {echo ' selected="selected" ';}
						echo '>' . $row['title'] . '</option>';
					}
				?>
			</select>
			
		</h1> 
		 
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>" /> 
			<div id="chooseFile">
				<input class="" id="file" type="file" name="file" /> 
			</div>
				 
			<input class="m-btn blue thinBorder" id="submit" type="submit" name="submit" value="Upload" /> 	
	 
	</form>
	</div>
</div>

<?php INCLUDE 'include/foot.php' ?>