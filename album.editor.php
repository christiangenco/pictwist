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
        if($row[title] == "Default")
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

<form id="Edit Album" action="<?php echo $baseURL . 'album.edit.processor.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Edit Album Info
    </h1> 

    <p> 
        <label for="title">New Album Title:</label> 
        <input id="title" type="text" value= "<?php echo $row['title']; ?>" name="title">
    </p>

    <p>
        <lable for="PrivateRadio">Would you like this album to be: </label>
        <input type="radio" name="PrivateRadio" value="Public" <?php echo ($row['private'] == '0')?'checked':' ' ?>/> Public
        <input type="radio" name="PrivateRadio" value="Private" <?php echo ($row['private'] == '1')?'checked':' ' ?>/> Private
    </p>

    <p>
        <input type="submit" name="AlbumSubmit" value="Submit" />
    </p> 
 
</form>

<form id="Delete Album" action="<?php echo $baseURL . 'album.deletion.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post">
    <p>
        <input type="submit" name="DeleteAlbum" value="Delete Album" />
    </p> 
</form> 

<?php INCLUDE 'include/foot.php' ?>