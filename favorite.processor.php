<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    if(isset($_SESSION['error']))
    {
        unset($_SESSION['error']);
    }
    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['p_id']))
    {
        connectToDb();
        $query = "SELECT photo_id, user_id FROM Favorites WHERE photo_id = ".$_REQUEST['p_id']." AND user_id = ".$currentUser['id'].";";
        $result = sql($query);
        if(mysql_num_rows($result) === 0)
        {
            $query = "Insert INTO Favorites(photo_id, user_id) VALUES(".$_REQUEST['p_id'].", ".$currentUser['id'].");";
            $result = sql($query);
            
            if(!$result)
            {
                $_SESSION['error'] = "Photo could not be added to your favorites.";
                $_SESSION['redirect'] = $viewURL;
                redirect($errorURL);
            }
            redirect($viewURL);
        }
        else
        {
            $query = "DELETE FROM Favorites WHERE photo_id = ".$_REQUEST['p_id']." AND user_id = ".$currentUser['id'].";";
            $result = sql($query);
            if(!$result)
            {
                $_SESSION['error'] = "Photo could not be deleted from your favorites.";
                $_SESSION['redirect'] = $viewURL;
                redirect($errorURL);
            }
            redirect($viewURL);
        }
    } 
    else
    {
        $_SESSION['error'] = 'Error! No photo selected for favoriting.';
        $_SESSION['redirect'] = $profileURL;
        redirect($errorURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>