<?php INCLUDE 'include/head.php';?>
<?php
    if(!isLoggedIn())
    {
        redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to favorite photos!");
    }
    else
    {
        connectToDb();
        
        if(isNotNull($_REQUEST['u_id']))
        {
            $u_id=params('u_id');
            $query = "SELECT user_id, user_id_subscriber FROM subscribes WHERE user_id = ".$u_id." AND user_id_subscriber = ".$currentUser['id'].";";
            echo $query . "<br/>";
            $result = sql($query);
            if(mysql_num_rows($result) === 0)
            {
                $query = "Insert INTO subscribes(user_id, user_id_subscriber) VALUES(".$u_id.", ".$currentUser['id'].");";
                echo $query . "<br/>";
                $result = sql($query);
                
                errorRedirect(!$result, "Subscription not completed.", $profileURL."?u_id=".$u_id);
                redirect($profileURL."?u_id=".$u_id);
            }
            else
            {
                $query = "DELETE FROM subscribes WHERE usr_id = ".$user_id." AND user_id_subscriber = ".$currentUser['id'].";";
                echo $query . "<br/>";
                $result = sql($query);
                errorRedirect(!$result, "Subscription not terminated.", $profileURL."?u_id=".$u_id);

                redirect($profileURL."?u_id=".$u_id);
            }
        } 
        else
        {
            errorRedirect(TRUE, "Error! You have not selected a user for subscribes.", $indexURL);
        }
    }
?>
<?php INCLUDE 'include/foot.php' ?>