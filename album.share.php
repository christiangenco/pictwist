<?php INCLUDE 'include/head.php'; ?>

<?php
    session_start();
    $albumsURL = $baseURL . 'albums.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['user']))
    {
        $uid = $currentUser['id'];
        $album_id = $_SESSION['album_id'];
        $user = $_REQUEST['user'];
        connectToDb();
        $query = "SELECT id from users where name = '$user';";
        $result = sql($query);
        $row = mysql_fetch_array($result);
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL); 
    }

    if(isset($row[id]) && $row[id] > 0)
    { 
        $query2 = "INSERT INTO shared VALUES ('$row[id]', '$album_id');";
        sql($query2); 
    }
    else
    {
        $_SESSION['error'] = 'User could not be found.';
        redirect($albumEditURL);
    }

    //go back to albums page
    redirect($albumsURL);

?>

<?php INCLUDE 'include/foot.php' ?>