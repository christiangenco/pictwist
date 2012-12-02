<?php INCLUDE 'include/head.php'; ?>

<?php
    $albumURL = $baseURL . 'album.photos.php?album_id=' . $_GET['album_id'];

    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['username']))
    {
        $uid = $currentUser['id'];
        $album_id = $_GET['album_id'];
        $user = $_REQUEST['username'];
        connectToDb();
        $query = "SELECT id from users where name = '$user';";
        $result = sql($query);
        $row = mysql_fetch_array($result);
    }
    else if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['useremail']))
    {
        $uid = $currentUser['id'];
        $album_id = $_GET['album_id'];
        $user = $_REQUEST['useremail'];
        connectToDb();
        $query = "SELECT id from users where email = '$user';";
        $result = sql($query);
        $row = mysql_fetch_array($result);
    }
    else if(!isset($currentUser['id']) <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to share albums!';
        redirect($logoutURL); 
    }

    if(isset($row[id]) && $row[id] > 0)
    { 
        $shared_id = $row[id];
        $query = "SELECT user_id, album_id FROM shared WHERE user_id = '$shared_id' AND album_id = '$album_id';";
        $result = sql($query);
        $row = mysql_fetch_array($result);
        if(empty($row))
        {
            $query2 = "INSERT INTO shared (user_id, album_id) VALUES ('$shared_id', '$album_id');";
            sql($query2); 
            //unset($_SESSION['a_id']);
            //go back to albums page
            redirect($albumURL);
        }
        else
        {
            $_SESSION['error'] = "Already shared this album with that user.";
            $_SESSION['redirect'] = $albumURL;
            redirect($albumURL);
        }
    }
    else
    {
        $_SESSION['error'] = 'User could not be found.';
        redirect($albumURL);
    }

?>

<?php INCLUDE 'include/foot.php' ?>