<?php INCLUDE 'include/head.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to contribute!");
    errorRedirect(!isset($_SESSION['photo_id']), "Tag could not be added.", $viewURL);
    connectToDb();
       if(isset($_POST['tagContent']) && $_POST['tagContent'] !== "")
        {
            $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'] . "', '" . $_POST['tagContent'] . "', '" . $_SESSION['photo_id'] . "');";
            $result = sql($query);
            errorRedirect(!$result, "Tag could not be added.", $viewURL);
        }
        if(isset($_POST['comment']) && $_POST['comment'] !== "")
        {
            $query = "insert into comments(text, user_id, photo_id) values('" . $_POST['comment'] . "', '" . $currentUser[id] . "', '" . $_SESSION['photo_id'] . "');";
            $result = sql($query);
            errorRedirect(!$result, "Comment could not be posted.", $viewURL);
        }
        if($_POST['lightbox']){redirect($viewLightBoxURL);}
        else
            {redirect($viewURL);}
?>
<?php INCLUDE 'include/foot.php' ?>