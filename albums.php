<?php INCLUDE 'include/head.php';?>

<?php

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
        <?php
	        while($row = mysql_fetch_array($result_albums))
	        {
	            if($row[title] != 'Favorites' && $row[title] != 'Default')
	            {
                    echo '<a href="album.editor.php?album_id=' . $row[id] . '">' . $row[title] . '</a><br/>';
	            }
	        }
        ?>
    </p> 
 
</form>

<?php INCLUDE 'include/foot.php' ?>