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
            $_SESSION['error'] = 'Error! You must be logged in!';
            redirect($logoutURL);
    }

    $title = $_POST['title'];

    //if no title is entered
    if(empty($title))
    {
        $num_albums = mysql_num_rows($result_albums);
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

    sql($sql);

    redirect($profileURL);
?>

<?php INCLUDE 'include/foot.php' ?>