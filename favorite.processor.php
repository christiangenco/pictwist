<?php INCLUDE 'include/head.php';?>
<?php
    if(!isLoggedIn())
    {
        redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to favorite photos!");
    }
    else
    {
        connectToDb();
        errorRedirect(isRestrictedPhoto($_REQUEST['p_id'], $_REQUEST['a_id']), "Error! You do not have permission to view this photo.", $profileURL);
        
        if(isNotNull($_REQUEST['p_id'])&&isNotNull($_REQUEST['a_id']))
        {
            $photo_id=params('p_id');
            $album_id=params('a_id');
            $query = "SELECT photo_id, user_id FROM favorites WHERE photo_id = ".$photo_id." AND user_id = ".$currentUser['id'].";";
            echo $query . "<br/>";
            $result = sql($query);
            if(mysql_num_rows($result) === 0)
            {
                $query = "Insert INTO favorites(photo_id, user_id) VALUES(".$photo_id.", ".$currentUser['id'].");";
                echo $query . "<br/>";
                $result = sql($query);
                
                errorRedirect(!$result, "Photo could not be added to your favorites.", $viewURL."?p_id=".$photo_id."&a_id=".$album_id);
                redirect($viewURL."?p_id=".$photo_id."&a_id=".$album_id);
            }
            else
            {
                $query = "DELETE FROM favorites WHERE photo_id = ".$photo_id." AND user_id = ".$currentUser['id'].";";
                echo $query . "<br/>";
                $result = sql($query);
                errorRedirect(!$result, "Photo could not be deleted from your favorites.", $viewURL."?p_id=".$photo_id."&a_id=".$album_id);

                redirect($viewURL."?p_id=".$photo_id."&a_id=".$album_id);
            }
        } 
        else
        {
            errorRedirect(TRUE, "Error! You have not selected a photo for favoriting.", $profileURL);
        }
    }
?>
<?php INCLUDE 'include/foot.php' ?>