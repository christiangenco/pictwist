<?php INCLUDE 'include/head.php'; ?>

<?php
    session_start();
    $albumURL = $baseURL . 'album.photos.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['username']))
    {
        $uid = $currentUser['id'];
        $album_id = $_SESSION['a_id'];
        $user = $_REQUEST['user'];
        connectToDb();
        $query = "SELECT id from users where name = '$username';";
        $result = sql($query);
        $row = mysql_fetch_array($result);
    }
    else if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['useremail']))
    {
        $uid = $currentUser['id'];
        $album_id = $_SESSION['a_id'];
        $user = $_REQUEST['user'];
        connectToDb();
        $query = "SELECT id from users where email = '$useremail';";
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
        if(empty($result))
        {
            $query2 = "INSERT INTO shared (user_id, album_id) VALUES ('$shared_id', '$album_id');";
            echo $query2;
            sql($query2); 
            unset($_SESSION['a_id']);
            //go back to albums page
            redirect($albumURL);
        }
        else
        {
            $_SESSION['error'] = "Already shared this album with that user.";
            $_SESSION['redirect'] = $albumURL;
            redirect($errorURL);
        }
    }
    else
    {
        $_SESSION['error'] = 'User could not be found.';
        redirect($albumURL);
    }

?>

<?php INCLUDE 'include/foot.php' ?>