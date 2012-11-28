<?php INCLUDE 'include/head.php'; ?>

<?php
    
    session_start();
    $_SESSION['album_id'] = $_POST['album_id'];

    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_POST['album_id']))
    {
        $uid = $currentUser['id'];
        $album_id = $_POST['album_id'];
        connectToDb();
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL); 
    }
?>

<form id="Edit Album" action="<?php echo $baseURL . 'album.edit.processor.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Edit Album 
    </h1> 

    <p> 
        <label for="title">New Album Title:</label> 
        <input id="title" type="text" value= "<?php print($_POST['title']); ?>" name="title">
    </p>

    <p>
        <lable for="PrivateRadio">Would you like this album to be: </label>
        <input type="radio" name="PrivateRadio" value="Public" /> Public
        <input type="radio" name="PrivateRadio" value="Private"/> Private
    </p>

    <p>
        <input type="submit" name="AlbumSubmit" value="Submit" />
    </p> 
 
</form>

<form id="Delete Album" action="<?php echo $baseURL . 'album.deletion.php' ?>" enctype="multipart/form-data" method="post">
    <p>
        <input type="submit" name="DeleteAlbum" value="Delete Album" />
    </p> 
</form> 


<?php INCLUDE 'include/foot.php' ?>