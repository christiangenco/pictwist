<?php INCLUDE 'include/head.php';?>

<?php
    //to pass album_id
    session_start();
    $albumsURL = $baseURL . 'albums.php';
    $edit = $baseURL . 'album.editor.php';

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        connectToDb();
        $uid = $currentUser['id'];  
        $album_id = $_SESSION['album_id'];
        $title = $_POST['title'];
        $private = 'unchecked';
        $public = 'unchecked';
        $selected_radio = $_POST['PrivateRadio'];
      
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in!';
            redirect($logoutURL);
    }

    if(!empty($title))
    {
        if (!mysql_query("UPDATE albums SET title= '$title' WHERE id= '$album_id'"))
            {
                die('Error: ' . mysql_error()); 
            }
    }

    if($selected_radio === 'Private')
    {
        $private = 'checked';
        if (!mysql_query("UPDATE albums SET private= '1' WHERE id= '$album_id'"))
            {
                die('Error: ' . mysql_error()); 
            }
    }
    else if($selected_radio === 'Public')
    {
        $public = 'checked';
        if (!mysql_query("UPDATE albums SET private= '0' WHERE id= '$album_id'"))
            {
                die('Error: ' . mysql_error()); 
            }
    }
    else
    {
        echo "Please choose whether the album should be public or private.";
        redirect($edit);
    }

    redirect($albumsURL);
?>

<?php INCLUDE 'include/foot.php' ?>