<?php INCLUDE 'include/head.php'; ?>

<?php
    session_start();
    $albumsURL = $baseURL . 'albums.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        $album_id = $_SESSION['album_id'];
        $user = $_POST['user'];
        connectToDb();
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL); 
    }

    $sql = "SELECT id from users where name = $user;";
    //check that the username exists in db
    if()
    sql($sql);
    
    //go back to albums page
    redirect($albumsURL);

?>

<?php INCLUDE 'include/foot.php' ?>