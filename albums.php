<?php INCLUDE 'include/head.php';?>

<?php
	// set a max file size for the html upload form 
    $max_file_size = 10000000; // size in bytes (AKA 10 MB)

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        
        connectToDb();
        
        $query = "select id, title from albums where user_id='".$uid."';";
        $result_albums = sql($query);
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your albums!';
            redirect($logoutURL);
    }    
?>

<form id="EditAlbums" action="<?php echo $baseURL . 'album.editor.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Edit Albums 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        Select Album:
        <select name="album_id">
	        <?php
		        while($row = mysql_fetch_array($result_albums))
		        {
		            if($row[title] != 'Favorites')
		            {
		                echo '<option value="' . $row[id] . '">' . $row[title] . '</option>';
		            }
		        }
	        ?>
        </select>
        <br/>
    </p> 
             
    <p> 
        <input id="Edit Album" type="submit" name="Edit Album]" value="Edit Album"> 
    </p> 
 
</form>

<form id="AddAlbum" action="<?php echo $baseURL . 'album.processor.php' ?>" method="post">
            <h2>
                Add an Album!
            </h2>

            <p>
                <label for="title">Album Title:</label> 
                <input type="text" name="title">
            </p>

            <p>
                Would you like this album to be private?
                <input type="checkbox" name="private" value="1" />
            </p>

            <p>
                <input type="submit" name="AlbumSubmit" value="Submit" />
            </p>

            </form>


<?php INCLUDE 'include/foot.php' ?>