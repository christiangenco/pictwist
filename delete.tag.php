<?php INCLUDE 'include/head.php';?>
<?php
    //echo "deleting...<br/>";
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to delete tags!");
    errorRedirect(!isNotNull($_REQUEST['a_id']) || !isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['t_id']), "Error! No tag selected for deletion.", $profileURL);
    $p_id = params('p_id');
    $a_id = params('a_id');
    $t_id = params('t_id');

    $query = "SELECT photo_id FROM tags WHERE id=".$t_id." AND photo_id=".$p_id.";";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
        $photo_id = $row['photo_id'];
    }
    else
    {
        errorRedirect(TRUE, "Error! No tag selected.", $profileURL);
    }

    if(!isOwner($photo_id) && !isAdmin())
    {
        errorRedirect(!isOwner($photo_id) && !isAdmin(), "Error! You do not have permission to delete this tag!", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
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
        $query = "Delete from tags WHERE id = ".$t_id;
        //echo $query . "<br/><br/>";
        $result = sql($query); 

        errorRedirect(!$result, "Error! Tag could not be deleted.", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
        //errorRedirect(!$result_path, "Error! Photo is not in the database.", $profileURL);
        redirect($viewURL."?p_id=".$p_id."&a_id=".$a_id);
    }
    
    
    //$p_id = params('p_id');
    
    
?>
<?php INCLUDE 'include/foot.php' ?>