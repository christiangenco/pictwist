<?php INCLUDE 'include/head.php';?>
<?php
    //echo "deleting...<br/>";
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to delete comments!");
    errorRedirect(!isNotNull($_REQUEST['a_id']) || !isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['c_id']), "Error! No comment selected for deletion.", $profileURL);
    $p_id = params('p_id');
    $a_id = params('a_id');
    $c_id = params('c_id');

    $query = "SELECT photo_id, user_id FROM comments WHERE id=".$c_id." AND photo_id=".$p_id.";";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
        $photo_id = $row['photo_id'];
        $user_id = $row['user_id'];
    }
    else
    {
        errorRedirect(TRUE, "Error! No comment selected.", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
    }

    if($user_id != $currentUser['id'] && !isOwner($photo_id) && !isAdmin())
    {
        errorRedirect($user_id != $currentUser['id'] && !isOwner($photo_id) && !isAdmin(), "Error! You do not have permission to delete this comment!", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
    }
    else
    {
        /*
        $query = "SELECT path FROM Photos WHERE id=".$p_id.";";
        //echo $query . "<br/><br/>";
        $result_path = sql($query);
        
        if($row = mysql_fetch_array($result_path))
        {
            unlink($row['path']);

        }
        */
        $query = "Delete from comments WHERE id = ".$c_id;
        //echo $query . "<br/><br/>";
        $result = sql($query); 

        errorRedirect(!$result, "Error! Comment could not be deleted.", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
        //errorRedirect(!$result_path, "Error! Photo is not in the database.", $profileURL);
        redirect($viewURL."?p_id=".$p_id."&a_id=".$a_id);
    }
    
    
    //$p_id = params('p_id');
    
    
?>
<?php INCLUDE 'include/foot.php' ?>