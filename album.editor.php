<?php INCLUDE 'include/head.php'; ?>

<?php
    //passing of album_id
    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        $a_id = $_GET['album_id'];
        connectToDb();

        $query = "SELECT title, private from albums where id = $a_id;";
        $result = sql($query);
        $row = mysql_fetch_array($result);
        if($row['title'] == "Default")
        {
            $_SESSION['error'] = "You cannot edit your Default album";
            redirect($albumsURL);
        }
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to edit albums!';
        redirect($logoutURL); 
    }
?>

<a class="returnLink" href="<?php echo $albumsURL;?>">< Back to my albums</a>
   

<div class="centerBox">

	<form id="Edit Album" action="<?php echo $baseURL . 'album.edit.processor.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
 
		<h1> 
			Edit Album Info
		</h1> 
	
		<div class="formContainer">

			<div class="m-input-prepend">
				<span class="add-on"><label for="title">Album Name:</label></span>
				<input class="m-wrap" id="title" type="text" value= "<?php echo $row['title']; ?>" name="title">
			</div>
		
			<select class="m-wrap m-ctrl-small" name="PrivateRadio">
				<option value="Public">Public</option>
				<option value="Private" <?php echo ($row['private'] == '1')?'selected':' ' ?>>Private</option>
			</select>
			<br />
				
			<input class="m-btn blue thinBorder" type="submit" name="AlbumSubmit" value="Submit" />		 

		</div>
	
	</form>
	
	<div class="boxDivider"></div>
	
	<form id="Delete Album" action="<?php echo $baseURL . 'album.deletion.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post">
	
		<input class="m-btn red thinBorder" type="submit" name="DeleteAlbum" value="Delete Album" />
	
	</form>
	
</div>

<?php INCLUDE 'include/foot.php' ?>