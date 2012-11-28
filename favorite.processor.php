<?php INCLUDE 'include/head.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to delete photos!");
    connectToDb();
    if(isNotNull($_REQUEST['p_id']))
    {
        $p_id=params('p_id');
        $query = "SELECT photo_id, user_id FROM Favorites WHERE photo_id = ".$p_id." AND user_id = ".$currentUser['id'].";";
        //echo $query . "<br/>";
        $result = sql($query);
        if(mysql_num_rows($result) === 0)
        {
            $query = "Insert INTO Favorites(photo_id, user_id) VALUES(".$p_id.", ".$currentUser['id'].");";
            //echo $query . "<br/>";
            $result = sql($query);
            
            errorRedirect(!$result, "Photo could not be added to your favorites.", $viewURL);
            redirect($viewURL);
        }
        else
        {
            $query = "DELETE FROM Favorites WHERE photo_id = ".$p_id." AND user_id = ".$currentUser['id'].";";
            //echo $query . "<br/>";
            $result = sql($query);
            errorRedirect(!$result, "Photo could not be deleted from your favorites.", $viewURL);

            redirect($viewURL);
        }
    } 
    else
    {
        errorRedirect(TRUE, "Error! You have not selected a photo for favoriting.", $profileURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>