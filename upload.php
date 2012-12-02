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

<form id="Upload" action="<?php echo $uploadHandlerURL ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Upload a Picture to 
        <select name="a_id">
            <?php
                while($row = mysql_fetch_array($result_albums))
                {
                    echo '<option value="' . $row['id'] . '"';
                    if($_GET['a_id']===$row['id']) {echo ' selected="selected" ';}
                    echo '>' . $row['title'] . '</option>';
                }
            ?>
        </select>
        ! 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>" /> 
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