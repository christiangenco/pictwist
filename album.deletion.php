<?php INCLUDE 'include/head.php'; ?>

<?php
    $albumsURL = $baseURL . 'albums.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        $album_id = $_GET['album_id'];
        connectToDb();
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL); 
    }
    $sql = "DELETE FROM albums WHERE id = '$album_id'";

    if (!mysql_query($sql))
    {
      die('Error: ' . mysql_error());
    }
    //go back to profile page
    redirect($profileURL);

?>

<?php INCLUDE 'include/foot.php' ?>