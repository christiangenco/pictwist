<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    if(isset($_SESSION['error']))
    {
        unset($_SESSION['error']);
    }
    if(isset($_POST['submit']) && isset($_SESSION['photo_id']))
    {
        connectToDb();
        //$error = "";
        // add new tags
        if(isset($_POST['tag']))
        {
            $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'] . "', '" . $_POST['tagContent'] . "', '" . $_SESSION['photo_id'] . "');";
            $result = sql($query);
            if(!$result)
            {
                //$error = 
                $_SESSION['error'] = "Tag could not be added.";
                $_SESSION['redirect'] = $editURL;
                redirect($errorURL);
            }
        }
        if(isset($_POST['comment']))
        {
            $query = "insert into comments(text, user_id, photo_id) values('" . $_POST['comment'] . "', '" . $currentUser[id] . "', '" . $_SESSION['photo_id'] . "');";
            $result = sql($query);
            if(!$result)
            {
                //$error = 
                $_SESSION['error'] = "Comment could not be posted.";
                $_SESSION['redirect'] = $editURL;
                redirect($errorURL);
            }
        }
        if($_POST['lightbox']){redirect($viewLightBoxURL);}
        else{redirect($viewURL);}
    } 
    else
    {
        $_SESSION['error'] = 'Error! No photo selected for editing.';
        $_SESSION['redirect'] = $profileURL;
        redirect($errorURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>