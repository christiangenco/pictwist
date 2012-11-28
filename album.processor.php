<?php INCLUDE 'include/head.php';?>

<?php
    $albumsURL = $baseURL . 'albums.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        
        connectToDb();
        
        $query = "select id, title from albums where user_id='".$uid."';";
        $result_albums = sql($query);
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in!';
            redirect($logoutURL);
    }

    $title = $_POST['title'];

    //if no title is entered
    if(empty($title))
    {
        $title = "New Album" . $album_num;
    }
    if(isset($_POST['private']))
    {
        $sql="INSERT INTO albums (title, private, user_id) VALUES('$title','$_POST[private]', $uid)";
    }
    else
    {
        $sql="INSERT INTO albums (title, user_id) VALUES('$title', $uid)";

    }

    if (!mysql_query($sql))
    {
      die('Error: ' . mysql_error());
    }

    redirect($albumsURL);
?>

<?php INCLUDE 'include/foot.php' ?>