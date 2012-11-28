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
            $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
            redirect($logoutURL);
    }
?>

<form id="Upload" action="<?php echo $uploadHandlerURL ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Upload a Picture! 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>" /> 
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
        <label for="file">Files to Upload:</label> 
        <input id="file" type="file" name="file" /> 
    </p> 
             
    <p> 
        <input id="submit" type="submit" name="submit" value="Proceed" /> 
    </p> 
 
</form>

<?php INCLUDE 'include/foot.php' ?>